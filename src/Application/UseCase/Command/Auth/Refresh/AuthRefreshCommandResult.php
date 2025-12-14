<?php

declare(strict_types=1);

namespace Blabster\Application\UseCase\Command\Auth\Refresh;

use Blabster\Application\Bus\Command\CommandResultInterface;

final readonly class AuthRefreshCommandResult implements CommandResultInterface
{
    public function __construct(
        public string $access_token,
    ) {
        /*_*/
    }
}
