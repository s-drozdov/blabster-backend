<?php

declare(strict_types=1);

namespace Blabster\Application\UseCase\Query\Ejabberd\CheckAccount;

use Blabster\Application\Bus\Query\QueryInterface;

final readonly class EjabberdAccountCheckQuery implements QueryInterface
{
    public function __construct(
        public string $user,
        public string $host,
    ) {
        /*_*/
    }
}
