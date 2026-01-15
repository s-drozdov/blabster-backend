<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\Enum;

enum Resource: string
{
    case Root = '/';
    case HealthCheck = '/health-check';
    case Login = '/login';
    case Logout = '/logout';
    case LogoutAll = '/logout-all';
    case MessengerAccount = '/messenger-account';
    case Otp = '/otp';
    case PowChallenge = '/pow-challenge';
    case Refresh = '/refresh';
}
