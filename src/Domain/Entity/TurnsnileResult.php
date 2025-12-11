<?php

declare(strict_types=1);

namespace Blabster\Domain\Entity;

use Override;
use Blabster\Domain\ValueObject\UuidInterface;
use DateTimeImmutable;

final readonly class TurnsnileResult implements EntityInterface
{
    public function __construct(
        private UuidInterface $uuid,
        private bool $success,
        private DateTimeImmutable $challenge_ts,
        private string $hostname,
    ) {
        /*_*/
    }

    #[Override]
    public function getUuid(): UuidInterface
    {
        return $this->uuid;
    }

    public function isSuccess(): bool
    {
        return $this->success;
    }

    public function getChallengeTs(): DateTimeImmutable
    {
        return $this->challenge_ts;
    }

    public function getHostname(): string
    {
        return $this->hostname;
    }
}
