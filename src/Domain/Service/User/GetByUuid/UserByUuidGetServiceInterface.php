<?php

declare(strict_types=1);

namespace Blabster\Domain\Service\User\GetByUuid;

use Blabster\Domain\Entity\User\User;
use Blabster\Domain\Service\ServiceInterface;
use Blabster\Domain\ValueObject\UuidInterface;

interface UserByUuidGetServiceInterface extends ServiceInterface
{
    public function perform(UuidInterface $uuid): User;
}
