<?php

declare(strict_types=1);

namespace Blabster\Application\UseCase\Command\Otp\Create;

use Blabster\Application\Bus\Command\CommandResultInterface;
use DateTimeImmutable;

final readonly class OtpCreateCommandResult implements CommandResultInterface
{
    public function __construct(
        public string $email,
        public ?DateTimeImmutable $ban_expires_at = null,
    ) {
        /*_*/
    }
}
