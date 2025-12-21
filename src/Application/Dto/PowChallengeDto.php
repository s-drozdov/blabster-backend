<?php

declare(strict_types=1);

namespace Blabster\Application\Dto;

use DateTimeImmutable;
use Blabster\Domain\ValueObject\UuidInterface;
use Blabster\Library\Dto\DtoInterface;

/**
 * @psalm-suppress ClassMustBeFinal The class cannot be final because it is used as a test double in PHPUnit
 */
readonly class PowChallengeDto implements DtoInterface
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
