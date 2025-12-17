<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\Enum;

enum OpenApiOperationId: string
{
    case AuthLogin = 'login';
    case AuthLogout = 'logout';
    case AuthLogoutAll = 'logoutAll';
    case AuthRefresh = 'refresh';
    case HealthCheck = 'checkHealth';
    case MessengerAccountGet = 'getMessengerAccount';
    case OtpCreate = 'createOtp';
    case PowChallengeCreate = 'createPowChallenge';
}
