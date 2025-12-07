<?php

declare(strict_types=1);

namespace Blabster\Domain\Entity;

use Blabster\Domain\Entity\EntityInterface;
use Blabster\Domain\Event\EventInterface;

interface AggregateInterface extends EntityInterface
{
    /**
     * @return EventInterface[]
     */
    public function pullEvents(): array;

    public function raise(EventInterface $event): void;

    public function isEventsEmpty(): bool;
}
