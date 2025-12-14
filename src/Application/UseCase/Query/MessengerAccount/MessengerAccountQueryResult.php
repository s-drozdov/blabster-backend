<?php

declare(strict_types=1);

namespace Blabster\Application\UseCase\Query\MessengerAccount;

use Blabster\Application\Bus\Query\QueryResultInterface;

final readonly class MessengerAccountQueryResult implements QueryResultInterface
{
    public function __construct(
        public string $login,
        public string $password,
    ) {
        /*_*/
    }
}
