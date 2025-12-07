<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\Messenger\Middleware;

use Override;
use RuntimeException;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Messenger\Middleware\StackInterface;
use Blabster\Application\Bus\Cache\BusCacheInterface;
use Blabster\Application\Bus\CqrsResultInterface;
use Blabster\Application\Bus\CqrsElementInterface;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;

final readonly class BusCacheMiddleware implements MiddlewareInterface
{
    private const string HANDLER_NAME = 'BusCacheMiddleware';

    public function __construct(
        private BusCacheInterface $busCache,
        private LoggerInterface $logger,
    ) {
        /*_*/
    }

    #[Override]
    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        $message = $envelope->getMessage();

        if (!$message instanceof CqrsElementInterface) {
            return $stack->next()->handle($envelope, $stack);
        }

        $result = $this->getFromBusCache($message);

        if ($result === null) {
            return $stack->next()->handle($envelope, $stack);
        }

        return $envelope->with(
            new HandledStamp(
                result: $result,
                handlerName: self::HANDLER_NAME,
            ),
        );
    }

    private function getFromBusCache(CqrsElementInterface $message): ?CqrsResultInterface
    {
        try {
            return $this->busCache->get($message);
        } catch (RuntimeException $e) {
            $this->logger->error($e);

            return null;
        }
    }
}
