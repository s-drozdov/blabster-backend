<?php

declare(strict_types=1);

namespace Blabster\Domain\Service\User\GetByEmail;

use Override;
use Blabster\Domain\Entity\User\User;
use Blabster\Domain\Repository\UserRepositoryInterface;

final readonly class UserByEmailGetService implements UserByEmailGetServiceInterface
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
    ) {
        /*_*/
    }

    #[Override]
    public function perform(string $email): ?User
    {
        return $this->userRepository->findByEmail($email);
    }
}
