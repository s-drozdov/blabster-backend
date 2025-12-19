<?php

declare(strict_types=1);

namespace Blabster\Application\Bus\Event;

use Exception;
use Blabster\Domain\Event\EventInterface;
use Blabster\Application\Bus\BusInterface;

interface EventBusInterface extends BusInterface
{   
    /**
     * @param EventInterface[] $eventList
     * 
     * @throws Exception
     */
    public function dispatch(...$eventList): void;
}
