<?php

declare(strict_types=1);

namespace Blabster\Library\SDK\Ejabberd\Enum;

enum EjabberdEndpoint: string
{
    case add_rosteritem = '/add_rosteritem';
    case check_account = '/check_account';
    case register = '/register';
}
