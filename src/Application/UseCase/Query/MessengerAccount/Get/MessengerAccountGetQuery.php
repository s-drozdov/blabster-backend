<?php

declare(strict_types=1);

namespace Blabster\Application\UseCase\Query\MessengerAccount\Get;

use Blabster\Application\Bus\Query\QueryInterface;

final readonly class MessengerAccountGetQuery implements QueryInterface
{
    public function __construct(
        public string $email,
    ) {
        /*_*/
    }
}
