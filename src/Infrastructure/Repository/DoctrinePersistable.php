<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\Repository;

use LogicException;
use DomainException;
use Webmozart\Assert\Assert;
use Doctrine\ORM\QueryBuilder;
use Blabster\Domain\Entity\EntityInterface;
use Blabster\Library\Collection\Collection;
use Blabster\Domain\ValueObject\UuidInterface;
use Blabster\Library\Collection\ListInterface;
use Blabster\Domain\Repository\RepositoryInterface;
use Blabster\Library\Helper\String\StringHelperInterface;

/**
 * @template T of EntityInterface
 * @phpstan-ignore trait.unused 
 */
trait DoctrinePersistable
{
    public const string COLUMN_NOT_FOUND = 'Column "%s" not found in row';
    
    /**
     * @param T $entity
     */
    public function save(EntityInterface $entity): void
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
    }

    /**
     * @param T $entity
     */
    public function update(EntityInterface $entity): void
    {
        $this->getEntityManager()->flush();
    }

    /**
     * @return T
     * @throws InvalidArgumentException
     */
    public function get(UuidInterface $uuid): EntityInterface
    {
        $entity = $this->find((string) $uuid);

        Assert::notNull(
            $entity, 
            sprintf(
                RepositoryInterface::ERROR_NOT_FOUND,
                $this->getStringHelper()->getClassShortName($this),
                (string) $uuid,
            ),
        );

        return $entity;
    }

    /**
     * @return T|null
     */
    public function findOne(UuidInterface $uuid): ?EntityInterface
    {
        return $this->find((string) $uuid);
    }

    /**
     * @param T $entity
     * 
     * @throws InvalidArgumentException
     */
    public function delete(EntityInterface $entity): void
    {
        $this->getEntityManager()->remove($entity);
        $this->getEntityManager()->flush();
    }

    /**
     * @param ListInterface<T> $entityList
     */
    public function bulkSave(ListInterface $entityList): void
    {
        foreach ($entityList as $entity) {
            $this->getEntityManager()->persist($entity);
        }

        $this->getEntityManager()->flush();
    }

    /**
     * @param ListInterface<T> $entityList
     */
    public function bulkUpdate(ListInterface $entityList): void
    {
        $this->getEntityManager()->flush();
    }

    /**
     * @param ListInterface<T> $entityList
     * 
     * @throws InvalidArgumentException
     */
    public function bulkDelete(ListInterface $entityList): void
    {
        foreach ($entityList as $entity) {
            $this->getEntityManager()->remove($entity);
        }

        $this->getEntityManager()->flush();
    }

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

    abstract private function getStringHelper(): StringHelperInterface;
}
