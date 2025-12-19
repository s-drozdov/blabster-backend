<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\OpenApi\Schema\UseCase\Command\User\Login;

use OpenApi\Attributes as OA;
use Blabster\Library\Enum\PhpType;
use Blabster\Domain\ValueObject\UuidInterface;

/**
 * @psalm-suppress MissingConstructor
 */
#[OA\Schema()]
final class UserLoginCommand
{
    public string $email;

    #[OA\Property(type: PhpType::string->value, nullable: false)]
    public UuidInterface $otp_uuid;

    public string $otp_code;
}
