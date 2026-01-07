<?php

declare(strict_types=1);

namespace Blabster\Application\UseCase\Query\MessengerAccount\Get;

use Blabster\Application\Bus\Query\QueryResultInterface;

final readonly class MessengerAccountGetQueryResult implements QueryResultInterface
{
    public function __construct(
        public string $login,
        public string $password,
        public string $host,
    ) {
        /*_*/
    }
}
