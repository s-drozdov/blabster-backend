<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\Enum;

enum Resource: string
{
    case Login = '/login';
    case Otp = '/otp';
    case Refresh = '/refresh';
    case PowChallenge = '/pow_challenge';
}
