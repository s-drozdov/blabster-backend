<?php

declare(strict_types=1);

namespace Blabster\Application\Dto\Converter;

use Blabster\Library\Dto\DtoInterface;
use Blabster\Domain\Entity\EntityInterface;
use Blabster\Library\Collection\Collection;
use Blabster\Library\Collection\ListInterface;
use Blabster\Domain\Aggregation\GroupAggregation;
use Blabster\Application\Dto\Mapper\MapperInterface;
use Blabster\Application\Dto\Aggregation\DtoGroupAggregation;

/**
 * @template TEntity of EntityInterface
 * @template TDto of DtoInterface
 * @template TGroupField of mixed
 */
final readonly class GroupAggregationConverter
{
    /**
     * @param ListInterface<GroupAggregation<TGroupField,TEntity>> $aggregationList
     * @param MapperInterface<TEntity, TDto> $mapper
     * 
     * @return ListInterface<DtoGroupAggregation<TGroupField,TDto>>
     */
    public function convert(ListInterface $aggregationList, MapperInterface $mapper): ListInterface
    {
        return new Collection(
            array_map(
                fn (GroupAggregation $aggregation) => $this->getDtoAggregation($aggregation, $mapper),
                $aggregationList->toArray(),
            ),
            DtoGroupAggregation::class,
        );
    }

    /**
     * @param GroupAggregation<TGroupField,TEntity> $aggregation
     * @param MapperInterface<TEntity, TDto> $mapper
     * 
     * @return DtoGroupAggregation<TGroupField,TDto>
     */
    private function getDtoAggregation(GroupAggregation $aggregation, MapperInterface $mapper): DtoGroupAggregation
    {
        return new DtoGroupAggregation(
            group: $aggregation->group,
            items: new Collection(
                array_map(

                    /** 
                     * @param TEntity $entity 
                     * 
                     * @return TDto
                     */
                    fn (EntityInterface $entity) => $mapper->mapDomainObjectToDto($entity),
                    
                    $aggregation->entityList->toArray(),
                ),
                $mapper->getDtoType(),
            ),
        );
    }
}
