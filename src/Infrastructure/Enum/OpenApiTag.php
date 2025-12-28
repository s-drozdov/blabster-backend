<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\Enum;

enum OpenApiTag: string
{
    case User = 'user';
    case MessengerAccount = 'messenger_account';
    case Otp = 'otp';
    case PowChallenge = 'pow_challenge';
    case Status = 'status';
}
