<?php

declare(strict_types=1);

namespace Blabster\Domain\Repository;

use Blabster\Domain\Entity\User;

/**
 * @extends RepositoryInterface<User>
 */
interface UserRepositoryInterface extends RepositoryInterface
{
    public function findByEmail(string $email): ?User;
}
