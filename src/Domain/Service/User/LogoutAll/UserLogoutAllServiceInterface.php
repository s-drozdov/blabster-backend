<?php

declare(strict_types=1);

namespace Blabster\Domain\Service\User\LogoutAll;

use Blabster\Domain\Entity\User\User;
use Blabster\Domain\Service\ServiceInterface;

interface UserLogoutAllServiceInterface extends ServiceInterface
{
    public function perform(string $refreshTokenValue): User;
}
