<?php

declare(strict_types=1);

namespace Blabster\Domain\Factory\User;

use Blabster\Domain\Entity\User\User;
use Blabster\Domain\Factory\FactoryInterface;
use Blabster\Domain\Entity\User\MessengerAccount;
use Blabster\Domain\Helper\Uuid\UuidHelperInterface;
use Blabster\Domain\Event\User\MessengerAccountRegistered;

final readonly class MessengerAcccountFactory implements FactoryInterface
{
    public function __construct(
        private UuidHelperInterface $uuidHelper,
    ) {
        /*_*/
    }

    public function create(User $user, string $login, string $password, string $host): MessengerAccount
    {
        $messengerAccount = new MessengerAccount(
            uuid: $this->uuidHelper->create(),
            user: $user,
            login: $login,
            password: $password,
            host: $host,
        );

        $user->raise(
            new MessengerAccountRegistered(
                login: $login,
                host: $host,
            ),
        );

        return $messengerAccount;
    }
}
