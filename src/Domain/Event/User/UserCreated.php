<?php

declare(strict_types=1);

namespace Blabster\Domain\Event\User;

use Blabster\Domain\Event\EventInterface;
use Blabster\Domain\ValueObject\UuidInterface;

final readonly class UserCreated implements EventInterface
{
    public function __construct(
        public UuidInterface $uuid,
    ) {
        /*_*/
    }
}
