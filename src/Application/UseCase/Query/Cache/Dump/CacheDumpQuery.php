<?php

declare(strict_types=1);

namespace Blabster\Application\UseCase\Query\Cache\Dump;

use Blabster\Application\Bus\Query\QueryInterface;

final readonly class CacheDumpQuery implements QueryInterface
{
    public function __construct(
        public string $key,
    ) {
        /*_*/
    }
}
