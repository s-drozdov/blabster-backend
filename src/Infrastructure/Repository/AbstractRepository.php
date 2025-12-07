<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\Repository;

use Override;
use LogicException;
use DomainException;
use Webmozart\Assert\Assert;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\EntityRepository;
use Blabster\Domain\Entity\EntityInterface;
use Blabster\Library\Collection\Collection;
use Blabster\Library\Collection\ListInterface;
use Blabster\Domain\Repository\RepositoryInterface;

/**
 * @template T of EntityInterface
 * @extends EntityRepository<T>
 * @implements RepositoryInterface<T>
 */
abstract class AbstractRepository extends EntityRepository implements RepositoryInterface
{
    private const string ERROR_NOT_FOUND = 'Entity with uuid %s is not found';
    private const string COLUMN_NOT_FOUND = 'Column "%s" not found in row';

    #[Override]
    public function save(EntityInterface $entity): void
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
    }

    #[Override]
    public function update(EntityInterface $entity): void
    {
        $this->getEntityManager()->flush();
    }

    #[Override]
    public function get(int $id): EntityInterface
    {
        $entity = $this->find($id);

        Assert::notNull(
            $entity, 
            sprintf(self::ERROR_NOT_FOUND, $id),
        );

        return $entity;
    }

    #[Override]
    public function findOne(int $id): ?EntityInterface
    {
        return $this->find($id);
    }

    #[Override]
    public function delete(EntityInterface $entity): void
    {
        $this->getEntityManager()->remove($entity);
        $this->getEntityManager()->flush();
    }

    #[Override]
    public function bulkSave(ListInterface $entityList): void
    {
        foreach ($entityList as $entity) {
            $this->getEntityManager()->persist($entity);
        }

        $this->getEntityManager()->flush();
    }

    #[Override]
    public function bulkUpdate(ListInterface $entityList): void
    {
        $this->getEntityManager()->flush();
    }

    #[Override]
    public function bulkDelete(ListInterface $entityList): void
    {
        foreach ($entityList as $entity) {
            $this->getEntityManager()->remove($entity);
        }

        $this->getEntityManager()->flush();
    }

    #[Override]
    public function countAll(): int
    {
        return $this->count();
    }

    /**
     * @return Collection<T>
     * @throws DomainException
     */
    protected function queryBuilderToList(QueryBuilder $qb): Collection
    {
        $entityList = $qb->getQuery()->getResult();

        if (!is_array($entityList)) {
            throw new DomainException();
        }

        /** @var array<array-key,T> $entityList */
        return new Collection($entityList, $this->getClassName());
    }

    /**
     * @return T|null
     */
    protected function queryBuilderToEntity(QueryBuilder $qb): ?EntityInterface
    {
        /** @var array<array-key,T> $entityList */
        $entityList = $qb->getQuery()->getResult();

        if (empty($entityList)) {
            return null;
        }

        return current($entityList);
    }

    /**
     * @return int
     */
    protected function countByQueryBuilder(QueryBuilder $qb): int
    {
        $countQb = clone $qb;

        $countQb->resetDQLPart('select');
        $rootAliases = $countQb->getRootAliases();

        $countQb->select(sprintf('COUNT(%s)', $rootAliases[0]));

        $count = (int) $countQb->getQuery()->getSingleScalarResult();

        return $count;
    }

    /**
     * @template TColumnValue
     * 
     * @return ListInterface<TColumnValue>
     * @phpstan-ignore method.templateTypeNotInParameter
     */
    protected function getColumn(QueryBuilder $qb, string $column): ListInterface
    {
        $qb->resetDQLPart('select');
        $qb->select($column);

        /** @var array<array<string, TColumnValue>> $rows */
        $rows = $qb->getQuery()->getScalarResult();

        $mapper = function (array $row) use ($column): mixed {
            if (!array_key_exists($column, $row)) {
                throw new LogicException(sprintf(self::COLUMN_NOT_FOUND, $column));
            }

            return $row[$column];
        };

        $result = new Collection(
            array_map($mapper, $rows),
            $this->getClassName(),
        );

        /** @var ListInterface<TColumnValue> $result */
        return $result;
    }
}
