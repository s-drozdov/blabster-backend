<?php

declare(strict_types=1);

namespace Blabster\Domain\Service\User\GetByEmail;

use Blabster\Domain\Entity\User\User;
use Blabster\Domain\Service\ServiceInterface;

interface UserByEmailGetServiceInterface extends ServiceInterface
{
    public function perform(string $email): ?User;
}
