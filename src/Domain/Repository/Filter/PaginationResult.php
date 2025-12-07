<?php

declare(strict_types=1);

namespace Blabster\Domain\Repository\Filter;

use Blabster\Library\Collection\ListInterface;

/**
 * @template T
 */
final readonly class PaginationResult
{
    public function __construct(

        /** @var ListInterface<T> $items */
        public ListInterface $items, 

        public int $total,
    ) {
        /*_*/
    }
}
