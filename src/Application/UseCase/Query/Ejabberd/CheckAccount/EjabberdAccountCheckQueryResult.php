<?php

declare(strict_types=1);

namespace Blabster\Application\UseCase\Query\Ejabberd\CheckAccount;

use Blabster\Application\Bus\Query\QueryResultInterface;

final readonly class EjabberdAccountCheckQueryResult implements QueryResultInterface
{
    public function __construct(
        public bool $is_user_exist,
    ) {
        /*_*/
    }
}
