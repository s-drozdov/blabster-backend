<?php

declare(strict_types=1);

namespace Blabster\Domain\Service\User\LogoutAll;

use Override;
use Blabster\Domain\Entity\User\User;
use Blabster\Domain\Repository\UserRepositoryInterface;

final readonly class UserLogoutAllService implements UserLogoutAllServiceInterface
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
    ) {
        /*_*/
    }

    #[Override]
    public function perform(string $email, string $refreshTokenValue): User
    {
        $user = $this->userRepository->getByEmailAndToken($email, $refreshTokenValue);

        $user->getRefreshTokenList()->clear();
        $this->userRepository->update($user);

        return $user;
    }
}
