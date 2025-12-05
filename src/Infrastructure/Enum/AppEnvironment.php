<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\Enum;

enum AppEnvironment: string
{
    case dev = 'development';
    case prod = 'production';
}
