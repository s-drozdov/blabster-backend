<?php

declare(strict_types=1);

namespace Blabster\Domain\Service\RefreshToken\Create;

use Blabster\Domain\Entity\User\RefreshToken;
use Blabster\Domain\Entity\User\User;
use Blabster\Domain\Service\ServiceInterface;
use Blabster\Domain\Factory\User\RefreshTokenFactory;
use Blabster\Domain\Repository\RefreshTokenRepositoryInterface;

final readonly class RefreshTokenCreateService implements ServiceInterface
{
    public function __construct(
        private RefreshTokenRepositoryInterface $refreshTokenRepository,
        private RefreshTokenFactory $refreshTokenFactory,
    ) {
        /*_*/
    }

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
