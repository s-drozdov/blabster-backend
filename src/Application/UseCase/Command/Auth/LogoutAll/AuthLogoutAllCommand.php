<?php

declare(strict_types=1);

namespace Blabster\Application\UseCase\Command\Auth\LogoutAll;

use Blabster\Application\Bus\Command\CommandInterface;
use Blabster\Domain\ValueObject\UuidInterface;

final readonly class AuthLogoutAllCommand implements CommandInterface
{
    public function __construct(
        public string $email,
        public string $refresh_token_value,
    ) {
        /*_*/
    }
}
