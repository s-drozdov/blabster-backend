<?php

declare(strict_types=1);

namespace Blabster\Library\SDK\Turnstile\Response;

use DateTimeImmutable;

final readonly class TurnstileResultDto
{
    public function __construct(
        public bool $success,
        public DateTimeImmutable $challenge_ts,
        public string $hostname,
    ) {
        /*_*/
    }
}
