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
        $em = $this->getEntityManager();

        $em->persist($entity);
        $em->flush();
    }

    #[Override]
    public function update(EntityInterface $entity): void
    {
        $em = $this->getEntityManager();
        $em->flush();
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
        $em = $this->getEntityManager();
        $em->remove($entity);
        $em->flush();
    }

    #[Override]
    public function bulkSave(array $entityList): void
    {
        $em = $this->getEntityManager();

        foreach ($entityList as $entity) {
            $em->persist($entity);
        }

        $em->flush();
    }

    #[Override]
    public function bulkUpdate(array $entityList): void
    {
        $em = $this->getEntityManager();
        $em->flush();
    }

    #[Override]
    public function bulkDelete(array $entityList): void
    {
        $em = $this->getEntityManager();

        foreach ($entityList as $entity) {
            $em->remove($entity);
        }

        $em->flush();
    }

    #[Override]
    public function countAll(): int
    {
        return $this->count();
    }

    /**
     * @return array<array-key,T>
     * @throws DomainException
     */
    protected function queryBuilderToList(QueryBuilder $qb): array
    {
        $entityList = $qb->getQuery()->getResult();

        if (!is_array($entityList)) {
            throw new DomainException();
        }

        /** @var array<array-key,T> $entityList */
        return $entityList;
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
     * @return array<array-key,TColumnValue>
     * @phpstan-ignore method.templateTypeNotInParameter
     */
    protected function getColumn(QueryBuilder $qb, string $column): array
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

        return array_map($mapper, $rows);
    }
}
