<?php

declare(strict_types=1);

namespace Blabster\Application\UseCase\Command\User\Logout;

use Blabster\Application\Bus\Command\CommandInterface;

final readonly class UserLogoutCommand implements CommandInterface
{
    public function __construct(
        public ?string $refresh_token_value,
    ) {
        /*_*/
    }
}
