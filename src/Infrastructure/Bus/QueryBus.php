<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\Bus;

use Override;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Blabster\Application\Bus\Query\QueryInterface;
use Blabster\Application\Bus\Query\QueryResultInterface;
use Blabster\Infrastructure\Bus\QueryBusInterface;

/**
 * @implements QueryBusInterface<QueryInterface, QueryResultInterface>
 */
final class QueryBus implements QueryBusInterface
{
    use HandleTrait;

    public function __construct(MessageBusInterface $queryBus)
    {
        $this->messageBus = $queryBus;
    }
    
    #[Override]
    public function execute($element): QueryResultInterface
    {
        try {
            /** @var QueryResultInterface $result */
            $result = $this->handle($element);

            return $result;
        } catch (HandlerFailedException $exception) {
            if (is_null($exception->getPrevious())) {
                throw $exception;
            }

            throw $exception->getPrevious();
        }
    }
}
