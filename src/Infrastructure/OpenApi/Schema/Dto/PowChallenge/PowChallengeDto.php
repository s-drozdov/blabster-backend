<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\OpenApi\Schema\Dto\PowChallenge;

use DateTimeImmutable;
use OpenApi\Attributes as OA;
use Blabster\Library\Enum\PhpType;
use Nelmio\ApiDocBundle\Attribute\Model;
use Blabster\Domain\ValueObject\UuidInterface;

/**
 * @psalm-suppress MissingConstructor
 */
#[OA\Schema()]
final class PowChallengeDto
{
    #[OA\Property(type: PhpType::string->value, nullable: true)]
    public UuidInterface $uuid;

    public string $prefix;

    public string $salt;

    public int $difficulty;

    #[OA\Property(type: PhpType::string->value, nullable: false)]
    public ?DateTimeImmutable $expires_at;
}
