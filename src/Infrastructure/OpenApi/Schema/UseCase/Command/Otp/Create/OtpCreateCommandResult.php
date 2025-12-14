<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\OpenApi\Schema\UseCase\Command\Otp\Create;

use DateTimeImmutable;
use OpenApi\Attributes as OA;
use Blabster\Library\Enum\PhpType;
use Blabster\Domain\ValueObject\UuidInterface;

/**
 * @psalm-suppress MissingConstructor
 */
#[OA\Schema()]
final class OtpCreateCommandResult
{
    public string $email;

    #[OA\Property(type: PhpType::string->value, nullable: true)]
    public ?UuidInterface $otp_uuid;

    #[OA\Property(type: PhpType::string->value, nullable: true)]
    public ?DateTimeImmutable $ban_expires_at;
}
