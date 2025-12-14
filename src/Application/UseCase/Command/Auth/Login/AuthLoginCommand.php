<?php

declare(strict_types=1);

namespace Blabster\Application\UseCase\Command\Auth\Login;

use Blabster\Application\Bus\Command\CommandInterface;
use Blabster\Domain\ValueObject\UuidInterface;

final readonly class AuthLoginCommand implements CommandInterface
{
    public function __construct(
        public string $email,
        public ?UuidInterface $otp_uuid,
        public string $otp_code,
    ) {
        /*_*/
    }
}
