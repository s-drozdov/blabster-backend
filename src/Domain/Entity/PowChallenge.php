<?php

declare(strict_types=1);

namespace Blabster\Domain\Entity;

use Override;
use DateTimeImmutable;
use Blabster\Domain\ValueObject\UuidInterface;

/**
 * @psalm-suppress ClassMustBeFinal The class cannot be final because it is used as a test double in PHPUnit
 */
class PowChallenge implements EntityInterface
{
    public function __construct(
        private UuidInterface $uuid,
        private string $prefix,
        private string $salt,
        private int $difficulty,
        private ?DateTimeImmutable $expires_at,
    ) {
        /*_*/
    }

    #[Override]
    public function getUuid(): UuidInterface
    {
        return $this->uuid;
    }

    public function getPrefix(): string
    {
        return $this->prefix;
    }

    public function getSalt(): string
    {
        return $this->salt;
    }

    public function getDifficulty(): int
    {
        return $this->difficulty;
    }

    public function getExpiresAt(): ?DateTimeImmutable
    {
        return $this->expires_at;
    }
}
