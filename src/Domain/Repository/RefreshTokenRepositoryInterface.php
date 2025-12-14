<?php

declare(strict_types=1);

namespace Blabster\Domain\Repository;

use Blabster\Domain\Entity\EntityInterface;
use Blabster\Domain\Entity\User\RefreshToken;
use Blabster\Domain\Repository\RepositoryInterface;

/**
 * @extends RepositoryInterface<RefreshToken>
 */
interface RefreshTokenRepositoryInterface extends RepositoryInterface
{
    /**
     * @return RefreshToken|null
     */
    public function findByToken(string $value): ?EntityInterface;

    public function save(RefreshToken $entity): void;
}
