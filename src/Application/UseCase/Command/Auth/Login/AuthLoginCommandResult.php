<?php

declare(strict_types=1);

namespace Blabster\Application\UseCase\Command\Auth\Login;

use Blabster\Application\Bus\Command\CommandResultInterface;
use DateTimeImmutable;

final readonly class AuthLoginCommandResult implements CommandResultInterface
{
    public function __construct(
        public string $access_token,
        public string $refresh_token_value,
        public DateTimeImmutable $refresh_token_expires_at,
    ) {
        /*_*/
    }
}
