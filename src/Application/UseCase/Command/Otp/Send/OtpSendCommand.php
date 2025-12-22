<?php

declare(strict_types=1);

namespace Blabster\Application\UseCase\Command\Otp\Send;

use Blabster\Application\Bus\Command\CommandInterface;

final readonly class OtpSendCommand implements CommandInterface
{
    public function __construct(
        public string $email,
        public string $otp_code,
    ) {
        /*_*/
    }
}
