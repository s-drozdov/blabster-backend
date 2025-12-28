<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\Enum;

enum OpenApiSummary: string
{
    case UserLogin = 'Login';
    case UserLogout = 'Logout';
    case UserLogoutAll = 'Logout from all devices';
    case UserRefresh = 'Refresh';
    case HealthCheck = 'Health check';
    case MessengerAccountGet = 'Get MessengerAccount';
    case OtpCreate = 'Create OTP';
    case PowChallengeCreate = 'Create PowChallenge';
}
