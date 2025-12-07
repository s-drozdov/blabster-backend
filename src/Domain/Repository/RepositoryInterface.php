<?php

declare(strict_types=1);

namespace Blabster\Domain\Repository;

use InvalidArgumentException;
use Blabster\Domain\Entity\EntityInterface;
use Blabster\Library\Collection\ListInterface;

/**
 * @template T of EntityInterface
 */
interface RepositoryInterface
{
    /**
     * @param T $entity
     */
    public function save(EntityInterface $entity): void;

    /**
     * @param T $entity
     */
    public function update(EntityInterface $entity): void;

    /**
     * @return T
     * @throws InvalidArgumentException
     */
    public function get(int $id): EntityInterface;

    /**
     * @return T|null
     */
    public function findOne(int $id): ?EntityInterface;

    /**
     * @param T $entity
     * 
     * @throws InvalidArgumentException
     */
    public function delete(EntityInterface $entity): void;

    /**
     * @param ListInterface<T> $entityList
     */
    public function bulkSave(ListInterface $entityList): void;

    /**
     * @param ListInterface<T> $entityList
     */
    public function bulkUpdate(ListInterface $entityList): void;

    /**
     * @param ListInterface<T> $entityList
     * 
     * @throws InvalidArgumentException
     */
    public function bulkDelete(ListInterface $entityList): void;

    public function countAll(): int;
}
