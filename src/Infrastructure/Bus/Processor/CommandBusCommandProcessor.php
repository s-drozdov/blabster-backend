<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\Bus\Processor;

use Blabster\Application\Bus\Command\CommandBusInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Blabster\Application\Bus\Command\CommandInterface;
use Blabster\Application\Bus\Command\CommandResultInterface;

/**
 * @template TElement of CommandInterface
 * @template TResult of CommandResultInterface
 * 
 * @extends AbstractCommandBusProcessor<TElement, TResult>
 */
final readonly class CommandBusCommandProcessor extends AbstractCommandBusProcessor
{
    /** 
     * @param CommandBusInterface<TElement, TResult> $commandBus
     */
    public function __construct(CommandBusInterface $commandBus,
                                SerializerInterface $serializer)
    {
        parent::__construct($commandBus, $serializer);
    }
}
