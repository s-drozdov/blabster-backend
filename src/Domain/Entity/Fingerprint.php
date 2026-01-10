<?php

declare(strict_types=1);

namespace Blabster\Domain\Entity;

use Override;
use Blabster\Domain\ValueObject\UuidInterface;
use DateTimeImmutable;

/**
 * @psalm-suppress ClassMustBeFinal The class cannot be final because it is used as a test double in PHPUnit
 */
class Fingerprint implements EntityInterface
{
    public function __construct(
        private UuidInterface $uuid,
        private string $value,
        private ?DateTimeImmutable $expires_at,
    ) {
        /*_*/
    }

    #[Override]
    public function getUuid(): UuidInterface
    {
        return $this->uuid;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function getExpiresAt(): ?DateTimeImmutable
    {
        return $this->expires_at;
    }
}
