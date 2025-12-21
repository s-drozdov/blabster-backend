<?php

declare(strict_types=1);

namespace Blabster\Domain\Service\RefreshToken\Create;

use Blabster\Domain\Entity\User\User;
use Blabster\Domain\Entity\User\RefreshToken;
use Blabster\Domain\Factory\User\RefreshTokenFactoryInterface;
use Blabster\Domain\Repository\RefreshTokenRepositoryInterface;
use Override;

final readonly class RefreshTokenCreateService implements RefreshTokenCreateServiceInterface
{
    public function __construct(
        private RefreshTokenRepositoryInterface $refreshTokenRepository,
        private RefreshTokenFactoryInterface $refreshTokenFactory,
    ) {
        /*_*/
    }

    #[Override]
    public function perform(User $user): RefreshToken
    {
        $refreshToken = $this->refreshTokenFactory->create(
            $user,
            bin2hex(random_bytes(32)),
        );

        $this->refreshTokenRepository->save($refreshToken);

        return $refreshToken;
    }
}
