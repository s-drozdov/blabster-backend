<?php

declare(strict_types=1);

namespace Blabster\Domain\Service\User\Logout;

use Blabster\Domain\Entity\User\User;
use Blabster\Domain\Service\ServiceInterface;

interface UserLogoutServiceInterface extends ServiceInterface
{
    public function perform(string $email, string $refreshTokenValue): User;
}
