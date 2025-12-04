<?php

declare(strict_types=1);

namespace Blabster\Backend\Infrastructure\Enum;

enum AppEnvironment: string
{
    case dev = 'development';
    case prod = 'production';
}
