<?php

declare(strict_types=1);

namespace Blabster\Application\UseCase\Command\Otp\Create;

use Blabster\Application\Bus\Command\CommandResultInterface;
use Blabster\Domain\ValueObject\UuidInterface;
use DateTimeImmutable;

final readonly class OtpCreateCommandResult implements CommandResultInterface
{
    public function __construct(
        public string $email,
        public ?UuidInterface $otp_uuid,
        public ?DateTimeImmutable $ban_expires_at = null,
    ) {
        /*_*/
    }
}
