<?php

declare(strict_types=1);

use Blabster\Application\Bus\Command\CommandInterface;
use Blabster\Application\Bus\Query\QueryInterface;
use Blabster\Infrastructure\Bus\CommandBus;
use Blabster\Infrastructure\Bus\QueryBus;

return [
    QueryInterface::class => QueryBus::class,
    CommandInterface::class => CommandBus::class,
];
