<?php

declare(strict_types=1);

namespace Blabster\Application\UseCase\Command\User\Refresh;

use Blabster\Application\Bus\Command\CommandResultInterface;

final readonly class UserRefreshCommandResult implements CommandResultInterface
{
    public function __construct(
        public string $access_token,
    ) {
        /*_*/
    }
}
