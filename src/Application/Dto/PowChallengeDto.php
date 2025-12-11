<?php

declare(strict_types=1);

namespace Blabster\Application\Dto;

use DateTimeImmutable;
use Blabster\Domain\ValueObject\UuidInterface;
use Blabster\Library\Dto\DtoInterface;

final readonly class PowChallengeDto implements DtoInterface
{
    public function __construct(
        public UuidInterface $uuid,
        public string $prefix,
        public string $salt,
        public int $difficulty,
        public ?DateTimeImmutable $expires_at,
    ) {
        /*_*/
    }
}
