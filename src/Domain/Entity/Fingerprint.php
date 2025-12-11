<?php

declare(strict_types=1);

namespace Blabster\Domain\Entity;

use Override;
use Blabster\Domain\ValueObject\UuidInterface;
use DateTimeImmutable;

final readonly class Fingerprint implements EntityInterface
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

    public function getExpiredAt(): ?DateTimeImmutable
    {
        return $this->expires_at;
    }
}
