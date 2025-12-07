<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\Repository\Aggregation;

use Doctrine\ORM\QueryBuilder;
use Blabster\Domain\Entity\EntityInterface;
use Blabster\Library\Collection\ListInterface;
use Blabster\Domain\Aggregation\GroupAggregation;

/** 
 * @template T of EntityInterface
 */
interface GroupAggregationProcessorInterface
{
    /**
     * @param class-string<T> $entityClass
     * 
     * @return ListInterface<GroupAggregation<mixed,T>>
     */
    public function process(QueryBuilder $qb, string $groupPropertyExpression, string $entityClass): ListInterface;
}
