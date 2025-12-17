<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\Enum;

enum OpenApiSchemaDescription: string
{
    case AuthLoginCommand = 'AuthLoginCommand';
    case AuthLoginCommandResult = 'AuthLoginCommandResult';
    case AuthLogoutCommand = 'AuthLogoutCommand';
    case AuthLogoutCommandResult = 'AuthLogoutCommandResult';
    case AuthLogoutAllCommand = 'AuthLogoutAllCommand';
    case AuthLogoutAllCommandResult = 'AuthLogoutAllCommandResult';
    case AuthRefreshCommand = 'AuthRefreshCommand';
    case AuthRefreshCommandResult = 'AuthRefreshCommandResult';
    case MessengerAccountQuery = 'MessengerAccountQuery';
    case MessengerAccountQueryResult = 'MessengerAccountQueryResult';
    case OtpCreateCommand = 'OtpCreateCommand';
    case OtpCreateCommandResult = 'OtpCreateCommandResult';
    case PowChallengeCreateCommandResult = 'PowChallengeCreateCommandResult';
    case status = 'status';
}
