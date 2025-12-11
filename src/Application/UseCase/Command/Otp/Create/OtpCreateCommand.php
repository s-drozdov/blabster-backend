<?php

declare(strict_types=1);

namespace Blabster\Application\UseCase\Command\Otp\Create;

use Blabster\Application\Bus\Command\CommandInterface;

final readonly class OtpCreateCommand implements CommandInterface
{
    public function __construct(
        public string $email,
        public string $pow_challenge_uuid,
        public string $pow_challenge_nonce,
        public string $fingerprint,
        public string $turnstile_token,
    ) {
        /*_*/
    }
}
