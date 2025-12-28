<?php

declare(strict_types=1);

namespace Blabster\Domain\Repository;

use InvalidArgumentException;
use Blabster\Domain\Entity\User\User;
use Blabster\Domain\Entity\EntityInterface;
use Blabster\Domain\ValueObject\UuidInterface;
use Blabster\Domain\Repository\RepositoryInterface;

/**
 * @extends RepositoryInterface<User>
 */
interface UserRepositoryInterface extends RepositoryInterface
{

    /**
     * @return User
     * @throws InvalidArgumentException
     */
    public function getByUuid(UuidInterface $uuid): EntityInterface;

    /**
     * @return User|null
     */
    public function findByEmail(string $email): ?EntityInterface;

    /**
     * @return User
     * @throws InvalidArgumentException
     */
    public function getByRefreshToken(string $refreshTokenValue): EntityInterface;

    public function save(User $entity): void;

    public function update(User $entity): void;
}
