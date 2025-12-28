<?php

declare(strict_types=1);

namespace Blabster\Domain\Service\User\Logout;

use Override;
use Webmozart\Assert\Assert;
use Blabster\Domain\Entity\User\User;
use Blabster\Domain\Repository\UserRepositoryInterface;
use Blabster\Domain\Repository\RefreshTokenRepositoryInterface;

final readonly class UserLogoutService implements UserLogoutServiceInterface
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private RefreshTokenRepositoryInterface $refreshTokenRepository,
    ) {
        /*_*/
    }

    #[Override]
    public function perform(string $refreshTokenValue): User
    {
        $user = $this->userRepository->getByRefreshToken($refreshTokenValue);
        
        $token = $this->refreshTokenRepository->findByToken($refreshTokenValue);
        Assert::notNull($token);

        $user->getRefreshTokenList()->removeElement($token);
        $this->userRepository->update($user);

        return $user;
    }
}
