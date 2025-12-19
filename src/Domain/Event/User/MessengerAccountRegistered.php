<?php

declare(strict_types=1);

namespace Blabster\Domain\Event\User;

use Blabster\Domain\Event\EventInterface;

final readonly class MessengerAccountRegistered implements EventInterface
{
    public function __construct(
        public string $login,
        public string $host,
    ) {
        /*_*/
    }
}
