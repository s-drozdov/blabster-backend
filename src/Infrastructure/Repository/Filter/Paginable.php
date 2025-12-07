<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\Repository\Filter;

use Blabster\Domain\Entity\EntityInterface;
use Blabster\Library\Collection\Collection;
use Blabster\Domain\Repository\Filter\FilterInterface;
use Blabster\Domain\Repository\Filter\PaginationResult;

/** 
 * @template T of EntityInterface
 * @phpstan-ignore trait.unused 
 */
trait Paginable
{
    /**
     * @param class-string<T> $entityClass
     * 
     * @return PaginationResult<T>
     */
    private function paginate(Builder $queryBuilder, FilterInterface $filter, string $entityClass): PaginationResult
    {
        $total = $filter->getPager()?->getTotal() ?? (clone $queryBuilder)
            ->count()
            ->getQuery()
            ->execute()
        ;

        if ($filter->getPager() !== null) {
            $queryBuilder
                ->skip($filter->getPager()->getOffset())
                ->limit($filter->getPager()->getLimit())
            ;
        }

        /** @var array<array-key, T> $entityList */
        $entityList = $queryBuilder
            ->getQuery()
            ->toArray()
        ;

        return new PaginationResult(
            items: new Collection($entityList, $entityClass),
            total: $total,
        );
    }
}
