<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\Enum;

enum CookieKey: string
{
    case RefreshToken = 'refresh_token';
}
