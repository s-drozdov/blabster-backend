<?php

declare(strict_types=1);

namespace Blabster\Domain\Service\User\GetByUuid;

use Override;
use Blabster\Domain\Entity\User\User;
use Blabster\Domain\ValueObject\UuidInterface;
use Blabster\Domain\Repository\UserRepositoryInterface;

final readonly class UserByUuidGetService implements UserByUuidGetServiceInterface
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
    ) {
        /*_*/
    }

    #[Override]
    public function perform(UuidInterface $uuid): User
    {
        return $this->userRepository->getByUuid($uuid);
    }
}
