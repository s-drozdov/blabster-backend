<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\Enum;

enum OpenApiOperationId: string
{
    case UserLogin = 'login';
    case UserLogout = 'logout';
    case UserLogoutAll = 'logoutAll';
    case UserRefresh = 'refresh';
    case HealthCheck = 'checkHealth';
    case MessengerAccountGet = 'getMessengerAccount';
    case OtpCreate = 'createOtp';
    case PowChallengeCreate = 'createPowChallenge';
}
