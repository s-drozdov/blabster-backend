<?php

declare(strict_types=1);

namespace Blabster\Application\UseCase\Command\Otp\Send;

use Blabster\Application\Bus\Command\CommandInterface;

final class OtpSendCommand implements CommandInterface
{
    public function __construct(
        public string $email,
        public string $proof_of_work_id,
        public string $proof_of_work_result,
        public string $fingerprint,
        public string $turnstile_token,
    ) {
        /*_*/
    }
}
