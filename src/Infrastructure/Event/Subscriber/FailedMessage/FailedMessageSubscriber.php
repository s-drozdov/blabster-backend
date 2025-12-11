<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\Event\Subscriber\FailedMessage;

use Override;
use Psr\Log\LoggerInterface;
use Symfony\Component\Mailer\Event\FailedMessageEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

final class FailedMessageSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private LoggerInterface $logger,
    ) {
        /*_*/
    }

    #[Override]
    public static function getSubscribedEvents(): array
    {
        return [
            FailedMessageEvent::class => 'onMessage',
        ];
    }

    public function onMessage(FailedMessageEvent $event): void
    {
        $error = $event->getError();

        if ($error instanceof TransportExceptionInterface) {
            $this->logger->debug($error->getDebug());
        }

        $this->logger->error($error);
        $this->logger->info($event->getMessage()->toString());
    }
}
