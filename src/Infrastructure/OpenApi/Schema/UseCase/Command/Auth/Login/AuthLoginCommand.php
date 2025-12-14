<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\OpenApi\Schema\UseCase\Command\Auth\Login;

use OpenApi\Attributes as OA;
use Blabster\Library\Enum\PhpType;
use Blabster\Domain\ValueObject\UuidInterface;

/**
 * @psalm-suppress MissingConstructor
 */
#[OA\Schema()]
final class AuthLoginCommand
{
    public string $email;

    #[OA\Property(type: PhpType::string->value, nullable: false)]
    public UuidInterface $otp_uuid;

    public string $otp_code;
}
