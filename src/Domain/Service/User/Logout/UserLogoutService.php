<?php

declare(strict_types=1);

namespace Blabster\Domain\Service\User\Logout;

use Webmozart\Assert\Assert;
use Blabster\Domain\Entity\User\User;
use Blabster\Domain\Service\ServiceInterface;
use Blabster\Domain\Repository\UserRepositoryInterface;
use Blabster\Domain\Repository\RefreshTokenRepositoryInterface;

final readonly class UserLogoutService implements ServiceInterface
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private RefreshTokenRepositoryInterface $refreshTokenRepository,
    ) {
        /*_*/
    }

    public function perform(string $email, string $refreshTokenValue): User
    {
        $user = $this->userRepository->getByEmailAndToken($email, $refreshTokenValue);
        
        $token = $this->refreshTokenRepository->findByToken($refreshTokenValue);
        Assert::notNull($token);

        $user->getRefreshTokenList()->removeElement($token);
        $this->userRepository->update($user);

        return $user;
    }
}
