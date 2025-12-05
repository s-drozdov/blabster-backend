<?php

declare(strict_types=1);

namespace Blabster\Domain\Repository;

use InvalidArgumentException;
use Blabster\Domain\Entity\EntityInterface;

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
     * @param array<array-key,T> $entityList
     */
    public function bulkSave(array $entityList): void;

    /**
     * @param array<array-key,T> $entityList
     */
    public function bulkUpdate(array $entityList): void;

    /**
     * @param array<array-key,T> $entityList
     * 
     * @throws InvalidArgumentException
     */
    public function bulkDelete(array $entityList): void;

    public function countAll(): int;
}
