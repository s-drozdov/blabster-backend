<?php

declare(strict_types=1);

namespace Blabster\Application\UseCase\Command\Otp\Send;

use Blabster\Application\Bus\Command\CommandResultInterface;

final class OtpSendCommandResult implements CommandResultInterface
{
    public function __construct(
        public string $email,
        public ?int $error_ttl = null,
    ) {
        /*_*/
    }
}
