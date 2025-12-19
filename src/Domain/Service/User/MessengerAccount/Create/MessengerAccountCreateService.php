<?php

declare(strict_types=1);

namespace Blabster\Domain\Service\User\MessengerAccount\Create;

use Blabster\Domain\Entity\User\User;
use Blabster\Domain\Service\ServiceInterface;
use Blabster\Domain\Repository\UserRepositoryInterface;
use Blabster\Domain\Factory\User\MessengerAcccountFactory;

final readonly class MessengerAccountCreateService implements ServiceInterface
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private MessengerAcccountFactory $messengerAcccountFactory,
    ) {
        /*_*/
    }

    public function perform(User $user, string $login, string $password, string $host): void
    {
        $user->setMessengerAccount(
            $this->messengerAcccountFactory->create($user, $login, $password, $host),
        );

        $this->userRepository->update($user);
    }
}
