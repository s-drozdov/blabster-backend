<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\Bus;

use Exception;
use Blabster\Domain\Event\EventInterface;

interface EventBusInterface extends BusInterface
{   
    /**
     * @param EventInterface[] $eventList
     * 
     * @throws Exception
     */
    public function execute(...$eventList): void;
}
