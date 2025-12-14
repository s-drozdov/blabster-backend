<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\Enum;

enum SameSite: string
{
    case Strict = 'strict';
    case Lax = 'lax';
}
