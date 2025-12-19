<?php

declare(strict_types=1);

namespace Blabster\Domain\Service\User\Create;

use Blabster\Domain\Entity\User\User;
use Blabster\Domain\Factory\User\UserFactory;
use Blabster\Domain\Service\ServiceInterface;
use Blabster\Domain\Repository\UserRepositoryInterface;

final readonly class UserCreateService implements ServiceInterface
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private UserFactory $userFactory,
    ) {
        /*_*/
    }

    public function perform(string $email): User
    {
        $user = $this->userFactory->create($email);
        $this->userRepository->save($user);

        return $user;
    }
}
