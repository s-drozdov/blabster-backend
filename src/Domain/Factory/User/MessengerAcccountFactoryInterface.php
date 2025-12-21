<?php

declare(strict_types=1);

namespace Blabster\Domain\Factory\User;

use Blabster\Domain\Entity\User\User;
use Blabster\Domain\Factory\FactoryInterface;
use Blabster\Domain\Entity\User\MessengerAccount;

interface MessengerAcccountFactoryInterface extends FactoryInterface
{
    public function create(User $user, string $login, string $password, string $host): MessengerAccount;
}
