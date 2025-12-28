<?php

declare(strict_types=1);

namespace Blabster\Domain\Service\User\GetByRefresh;

use Override;
use Blabster\Domain\Entity\User\User;
use Blabster\Domain\Repository\UserRepositoryInterface;

final readonly class UserByRefreshGetService implements UserByRefreshGetServiceInterface
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
    ) {
        /*_*/
    }

    #[Override]
    public function perform(string $refreshTokenValue): User
    {
        return $this->userRepository->getByRefreshToken($refreshTokenValue);
    }
}
