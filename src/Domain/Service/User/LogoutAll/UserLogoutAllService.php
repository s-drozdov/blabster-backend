<?php

declare(strict_types=1);

namespace Blabster\Domain\Service\User\LogoutAll;

use Blabster\Domain\Service\ServiceInterface;
use Blabster\Domain\Repository\UserRepositoryInterface;

final readonly class UserLogoutAllService implements ServiceInterface
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
    ) {
        /*_*/
    }

    public function perform(string $email, string $refreshTokenValue): void
    {
        $user = $this->userRepository->getByEmailAndToken($email, $refreshTokenValue);

        $user->getRefreshTokenList()->clear();
        $this->userRepository->update($user);
    }
}
