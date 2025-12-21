<?php

declare(strict_types=1);

namespace Blabster\Domain\Service\User\Create;

use Override;
use Blabster\Domain\Entity\User\User;
use Blabster\Domain\Factory\User\UserFactoryInterface;
use Blabster\Domain\Repository\UserRepositoryInterface;

final readonly class UserCreateService implements UserCreateServiceInterface
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private UserFactoryInterface $userFactory,
    ) {
        /*_*/
    }

    #[Override]
    public function perform(string $email): User
    {
        $user = $this->userFactory->create($email);
        $this->userRepository->save($user);

        return $user;
    }
}
