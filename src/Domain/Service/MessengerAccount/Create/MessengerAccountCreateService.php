<?php

declare(strict_types=1);

namespace Blabster\Domain\Service\MessengerAccount\Create;

use Blabster\Domain\Entity\User\User;
use Blabster\Domain\Repository\UserRepositoryInterface;
use Blabster\Domain\Factory\User\MessengerAcccountFactoryInterface;
use Override;

final readonly class MessengerAccountCreateService implements MessengerAccountCreateServiceInterface
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private MessengerAcccountFactoryInterface $messengerAcccountFactory,
    ) {
        /*_*/
    }

    #[Override]
    public function perform(User $user, string $login, string $password, string $host): void
    {
        $user->setMessengerAccount(
            $this->messengerAcccountFactory->create($user, $login, $password, $host),
        );

        $this->userRepository->update($user);
    }
}
