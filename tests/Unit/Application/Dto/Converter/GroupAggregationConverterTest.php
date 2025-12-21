<?php

declare(strict_types=1);

namespace Blabster\Tests\Unit\Application\Dto\Converter;

use LogicException;
use PHPUnit\Framework\TestCase;
use Blabster\Library\Dto\DtoInterface;
use PHPUnit\Framework\Attributes\Test;
use Blabster\Domain\Entity\EntityInterface;
use Blabster\Library\Collection\Collection;
use Blabster\Domain\Aggregation\GroupAggregation;
use Blabster\Application\Dto\Mapper\MapperInterface;
use Blabster\Application\Dto\Aggregation\DtoGroupAggregation;
use Blabster\Application\Dto\Converter\GroupAggregationConverter;

final class GroupAggregationConverterTest extends TestCase
{
    private const string GROUP = 'group-1';

    #[Test]
    public function testConvertMapsGroupAggregationsToDtoAggregations(): void
    {
        // arrange
        $entity1 = $this->createStub(EntityInterface::class);
        $entity2 = $this->createStub(EntityInterface::class);

        $dto1 = $this->createStub(DtoInterface::class);
        $dto2 = $this->createStub(DtoInterface::class);

        $aggregation = new GroupAggregation(
            group: self::GROUP,
            entityList: new Collection([$entity1, $entity2], EntityInterface::class),
        );

        $aggregationList = new Collection(
            [$aggregation],
            GroupAggregation::class,
        );

        $mapper = $this->createMock(MapperInterface::class);

        $call = 0;

        $mapper
            ->expects(self::exactly(2))
            ->method('mapDomainObjectToDto')
            ->willReturnCallback(
                static function (EntityInterface $entity) use (&$call, $entity1, $entity2, $dto1, $dto2) {
                    return match (++$call) {
                        1 => $entity === $entity1 ? $dto1 : throw new LogicException(),
                        2 => $entity === $entity2 ? $dto2 : throw new LogicException(),
                        default => throw new LogicException(),
                    };
                },
            )
        ;

        $mapper->expects(self::once())->method('getDtoType')->willReturn(DtoInterface::class);

        $converter = new GroupAggregationConverter();
        
        // act
        $result = $converter->convert($aggregationList, $mapper);
        
        // assert
        self::assertCount(1, $result);

        $dtoAggregation = $result->toArray()[0];
        
        self::assertInstanceOf(DtoGroupAggregation::class, $dtoAggregation);
        self::assertSame(self::GROUP, $dtoAggregation->group);
        self::assertSame([$dto1, $dto2], $dtoAggregation->items->toArray());
    }
}
