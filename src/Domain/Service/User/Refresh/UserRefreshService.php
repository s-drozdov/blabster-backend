<?php

declare(strict_types=1);

namespace Blabster\Domain\Service\User\Refresh;

use Blabster\Domain\Entity\User\User;
use Blabster\Domain\Service\ServiceInterface;
use Blabster\Domain\Repository\UserRepositoryInterface;

final readonly class UserRefreshService implements ServiceInterface
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
    ) {
        /*_*/
    }

    public function perform(string $email, string $refreshTokenValue): User
    {
        return $this->userRepository->getByEmailAndToken($email, $refreshTokenValue);
    }
}
