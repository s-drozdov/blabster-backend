<?php

declare(strict_types=1);

namespace Blabster\Domain\Service\MessengerAccount\Create;

use Blabster\Domain\Entity\User\User;
use Blabster\Domain\Service\ServiceInterface;

interface MessengerAccountCreateServiceInterface extends ServiceInterface
{
    public function perform(User $user, string $login, string $password, string $host): void;
}
