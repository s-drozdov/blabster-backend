<?php

declare(strict_types=1);

namespace Blabster\Domain\Entity\User;

use Override;
use Blabster\Domain\Entity\User\User;
use Blabster\Domain\Entity\EntityInterface;
use Blabster\Domain\ValueObject\UuidInterface;

/**
 * @psalm-suppress ClassMustBeFinal The class cannot be final because it is used as a test double in PHPUnit
 */
class MessengerAccount implements EntityInterface
{
    public function __construct(
        private UuidInterface $uuid,
        private User $user,
        private string $login,
        private string $password,
        private string $host,
    ) {
        /*_*/
    }

    #[Override]
    public function getUuid(): UuidInterface
    {
        return $this->uuid;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getLogin(): string
    {
        return $this->login;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getHost(): string
    {
        return $this->host;
    }
}
