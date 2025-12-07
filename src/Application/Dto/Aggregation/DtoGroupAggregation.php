<?php

declare(strict_types=1);

namespace Blabster\Application\Dto\Aggregation;

use Blabster\Library\Dto\DtoInterface;
use Blabster\Library\Collection\ListInterface;

/**
 * @template TGroupField of mixed
 * @template TDto of DtoInterface
 */
final readonly class DtoGroupAggregation
{
    public function __construct(

        /** @var TGroupField $group */
        public mixed $group,

        /** @var ListInterface<TDto> $items */
        public ListInterface $items,
    ) {
        /*_*/
    }
}
