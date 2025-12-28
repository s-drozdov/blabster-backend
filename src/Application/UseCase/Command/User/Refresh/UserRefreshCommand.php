<?php

declare(strict_types=1);

namespace Blabster\Application\UseCase\Command\User\Refresh;

use Blabster\Application\Bus\Command\CommandInterface;

final readonly class UserRefreshCommand implements CommandInterface
{
    public function __construct(
        public string $refresh_token_value,
    ) {
        /*_*/
    }
}
