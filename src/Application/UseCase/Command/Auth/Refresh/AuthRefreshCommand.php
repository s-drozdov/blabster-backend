<?php

declare(strict_types=1);

namespace Blabster\Application\UseCase\Command\Auth\Refresh;

use Blabster\Application\Bus\Command\CommandInterface;

final readonly class AuthRefreshCommand implements CommandInterface
{
    public function __construct(
        public string $email,
        public string $refresh_token_value,
    ) {
        /*_*/
    }
}
