<?php

declare(strict_types=1);

namespace Blabster\Domain\Service\User\GetByEmail;

use Blabster\Domain\Entity\User\User;
use Blabster\Domain\Service\ServiceInterface;
use Blabster\Domain\Repository\UserRepositoryInterface;

final readonly class UserByEmailGetService implements ServiceInterface
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
    ) {
        /*_*/
    }

    public function perform(string $email): ?User
    {
        return $this->userRepository->findByEmail($email);
    }
}
