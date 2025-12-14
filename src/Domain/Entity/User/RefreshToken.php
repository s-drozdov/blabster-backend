<?php

declare(strict_types=1);

namespace Blabster\Domain\Entity\User;

use Override;
use Blabster\Domain\Entity\EntityInterface;
use Blabster\Domain\ValueObject\UuidInterface;
use DateTimeImmutable;

final readonly class RefreshToken implements EntityInterface
{
    public function __construct(
        private UuidInterface $uuid,
        private User $user,
        private string $value,
        private DateTimeImmutable $expires_at,
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

    public function getValue(): string
    {
        return $this->value;
    }

    public function getExpiresAt(): DateTimeImmutable
    {
        return $this->expires_at;
    }
}
