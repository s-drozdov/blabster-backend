<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\Enum;

enum OpenApiSchemaDescription: string
{
    case UserLoginCommand = 'UserLoginCommand';
    case UserLoginCommandResult = 'UserLoginCommandResult';
    case UserLogoutCommand = 'UserLogoutCommand';
    case UserLogoutCommandResult = 'UserLogoutCommandResult';
    case UserLogoutAllCommand = 'UserLogoutAllCommand';
    case UserLogoutAllCommandResult = 'UserLogoutAllCommandResult';
    case UserRefreshCommand = 'UserRefreshCommand';
    case UserRefreshCommandResult = 'UserRefreshCommandResult';
    case MessengerAccountGetQuery = 'MessengerAccountGetQuery';
    case MessengerAccountGetQueryResult = 'MessengerAccountGetQueryResult';
    case OtpCreateCommand = 'OtpCreateCommand';
    case OtpCreateCommandResult = 'OtpCreateCommandResult';
    case PowChallengeCreateCommandResult = 'PowChallengeCreateCommandResult';
    case status = 'status';
}
