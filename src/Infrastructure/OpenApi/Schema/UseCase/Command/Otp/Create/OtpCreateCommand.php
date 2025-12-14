<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\OpenApi\Schema\UseCase\Command\Otp\Create;

use OpenApi\Attributes as OA;
use Blabster\Library\Enum\PhpType;
use Blabster\Domain\ValueObject\UuidInterface;

/**
 * @psalm-suppress MissingConstructor
 */
#[OA\Schema()]
final class OtpCreateCommand
{
    public string $email;
    
    #[OA\Property(type: PhpType::string->value, nullable: false)]
    public UuidInterface $pow_challenge_uuid;

    public string $pow_challenge_nonce;
    public string $fingerprint;
    public string $turnstile_token;
}
