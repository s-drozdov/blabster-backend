<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\Bus;

use Override;
use DI\Container;
use LogicException;
use Blabster\Application\Bus\CqrsResultInterface;
use Blabster\Infrastructure\Bus\CqrsBusInterface;
use Blabster\Application\Bus\CqrsElementInterface;
use Blabster\Application\Bus\Query\QueryResultInterface;

/**
 * @implements CqrsBusInterface<CqrsElementInterface,CqrsResultInterface>
 */
final readonly class CqrsBus implements CqrsBusInterface
{
    private const string CANNOT_RESOLVE_BUS = 'Cannot resolve bus for element %s';

    public function __construct(

        /** @var array<class-string<CqrsElementInterface>,class-string<CqrsBusInterface<CqrsElementInterface,CqrsResultInterface>>> $cqrsElementToBusMap */
        private array $cqrsElementToBusMap,

        private Container $container,
    ) {
        /*_*/
    }

    /**
     * @throws LogicException
     */
    #[Override]
    public function execute($element): CqrsResultInterface
    {
        if (isset($this->cqrsElementToBusMap[$element::class])) {
            /** @var CqrsBusInterface<CqrsElementInterface,CqrsResultInterface> $bus */
            $bus = $this->container->get(
                $this->cqrsElementToBusMap[$element::class],
            );
            
            /** @var QueryResultInterface @return */
            return $bus->execute($element);
        }

        throw new LogicException(
            sprintf(self::CANNOT_RESOLVE_BUS, $element::class),
        );
    }
}
