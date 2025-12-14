<?php

declare(strict_types=1);

namespace Blabster\Application\UseCase\Query\MessengerAccount;

use Blabster\Application\Bus\Query\QueryInterface;

final readonly class MessengerAccountQuery implements QueryInterface
{
    public function __construct(
        public string $email,
    ) {
        /*_*/
    }
}
