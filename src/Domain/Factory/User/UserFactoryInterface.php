<?php

declare(strict_types=1);

namespace Blabster\Domain\Factory\User;

use Blabster\Domain\Entity\User\User;
use Blabster\Domain\Factory\FactoryInterface;

interface UserFactoryInterface extends FactoryInterface
{
    public function create(string $email): User;
}
