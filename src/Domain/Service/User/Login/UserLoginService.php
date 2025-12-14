<?php

declare(strict_types=1);

namespace Blabster\Domain\Service\User\Login;

use Blabster\Domain\Entity\User\User;
use Blabster\Domain\Factory\UserFactory;
use Blabster\Domain\Bus\EventBusInterface;
use Blabster\Domain\Service\ServiceInterface;
use Blabster\Domain\Repository\UserRepositoryInterface;

final readonly class UserLoginService implements ServiceInterface
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private UserFactory $userFactory,
        private EventBusInterface $eventBus,
    ) {
        /*_*/
    }

    public function perform(string $email): User
    {
        $user = $this->userRepository->findByEmail($email);

        if ($user !== null) {
            return $user;
        }

        return $this->createUser($email);
    }
    
    private function createUser(string $email): User
    {
        $user = $this->userFactory->create($email);

        $this->userRepository->save($user);

        $this->eventBus->dispatch(...$user->pullEvents());

        return $user;
    }
}
