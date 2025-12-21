<?php

declare(strict_types=1);

namespace Blabster\Domain\Service\RefreshToken\Create;

use Blabster\Domain\Entity\User\User;
use Blabster\Domain\Entity\User\RefreshToken;
use Blabster\Domain\Service\ServiceInterface;

interface RefreshTokenCreateServiceInterface extends ServiceInterface
{
    public function perform(User $user): RefreshToken;
}
