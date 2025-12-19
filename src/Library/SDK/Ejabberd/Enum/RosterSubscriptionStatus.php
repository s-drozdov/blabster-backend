<?php

declare(strict_types=1);

namespace Blabster\Library\SDK\Ejabberd\Enum;

enum RosterSubscriptionStatus: string
{
    case EveryoneSee = 'both';
    case ContactSeeAccountStatus = 'from';
    case AccountSeeContactStatus = 'to';
    case NoOneSee = 'none';
}
