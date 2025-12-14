<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\Enum;

enum Action: string
{
    case auth_login = Resource::Login->value;
    case auth_refresh = Resource::Refresh->value;
    case otp_create = Resource::Otp->value;
    case pow_challenge_create = Resource::PowChallenge->value;
}
