<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\Bus;

use Override;
use DI\Container;
use LogicException;
use Blabster\Application\Bus\CqrsResultInterface;
use Blabster\Application\Bus\CqrsElementInterface;
use Blabster\Application\Bus\CqrsHandlerInterface;
use Blabster\Application\Bus\Command\CommandInterface;
use Blabster\Application\Bus\Command\CommandResultInterface;
use Blabster\Application\Bus\Command\CommandHandlerInterface;

/**
 * @implements CommandBusInterface<CommandInterface,CommandResultInterface>
 */
final readonly class CommandBus implements CommandBusInterface
{
    private const string CANNOT_RESOLVE_HANDLER = 'Cannot resolve bus handler for element %s';

    public function __construct(

        /** @var array<class-string<CqrsElementInterface>,class-string<CqrsHandlerInterface<CqrsElementInterface,CqrsResultInterface>>> $cqrsElementToHandlerMap */
        private array $cqrsElementToHandlerMap,

        private Container $container,
    ) {
        /*_*/
    }

    #[Override]
    public function execute($element): CommandResultInterface
    {
        if (isset($this->cqrsElementToHandlerMap[$element::class])) {
            /** @var CommandHandlerInterface<CommandInterface,CommandResultInterface> $handler */
            $handler = $this->container->get(
                $this->cqrsElementToHandlerMap[$element::class],
            );
            
            /** @var CommandResultInterface @return */
            return $handler($element);
        }

        throw new LogicException(
            sprintf(self::CANNOT_RESOLVE_HANDLER, $element::class),
        );
    }
}
