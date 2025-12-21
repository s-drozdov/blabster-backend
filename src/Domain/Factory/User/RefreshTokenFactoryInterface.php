<?php

declare(strict_types=1);

namespace Blabster\Domain\Factory\User;

use Blabster\Domain\Entity\User\User;
use Blabster\Domain\Entity\User\RefreshToken;
use Blabster\Domain\Factory\FactoryInterface;

interface RefreshTokenFactoryInterface extends FactoryInterface
{
    public function create(User $user, string $tokenValue): RefreshToken;
}
