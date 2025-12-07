<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\Bus;

use Override;
use DI\Container;
use LogicException;
use Blabster\Application\Bus\CqrsResultInterface;
use Blabster\Application\Bus\CqrsElementInterface;
use Blabster\Application\Bus\CqrsHandlerInterface;
use Blabster\Application\Bus\Query\QueryInterface;
use Blabster\Application\Bus\Query\QueryResultInterface;
use Blabster\Application\Bus\Query\QueryHandlerInterface;

/**
 * @implements QueryBusInterface<QueryInterface,QueryResultInterface>
 */
final readonly class QueryBus implements QueryBusInterface
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
    public function execute($element): QueryResultInterface
    {
        if (isset($this->cqrsElementToHandlerMap[$element::class])) {
            /** @var QueryHandlerInterface<QueryInterface,QueryResultInterface> $handler */
            $handler = $this->container->get(
                $this->cqrsElementToHandlerMap[$element::class],
            );
            
            /** @var QueryResultInterface @return */
            return $handler($element);
        }

        throw new LogicException(
            sprintf(self::CANNOT_RESOLVE_HANDLER, $element::class),
        );
    }
}
