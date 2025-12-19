<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\Bus;

use Override;
use Blabster\Domain\Event\EventInterface;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Blabster\Application\Bus\Event\EventBusInterface;

final class EventBus implements EventBusInterface
{
    use HandleTrait;

    public function __construct(MessageBusInterface $eventBus)
    {
        $this->messageBus = $eventBus;
    }
    
    /**
     * @inheritdoc
     * @param EventInterface[] $eventList
     */
    #[Override]
    public function dispatch(...$eventList): void
    {
        /** @var EventInterface $event */
        foreach ($eventList as $event) {
            $this->messageBus->dispatch($event);
        }
    }
}
