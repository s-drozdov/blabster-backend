<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\Enum;

enum OpenApiSummary: string
{
    case AuthLogin = 'Login';
    case AuthLogout = 'Logout';
    case AuthLogoutAll = 'Logout from all devices';
    case AuthRefresh = 'Refresh';
    case HealthCheck = 'Health check';
    case MessengerAccountGet = 'Get MessengerAccount';
    case OtpCreate = 'Create OTP';
    case PowChallengeCreate = 'Create PowChallenge';
}
