<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\Bus;

use Override;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Blabster\Domain\Event\EventInterface;
use Blabster\Infrastructure\Bus\EventBusInterface;

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
    public function execute(...$eventList): void
    {
        /** @var EventInterface $event */
        foreach ($eventList as $event) {
            $this->messageBus->dispatch($event);
        }
    }
}
