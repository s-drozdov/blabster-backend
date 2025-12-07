<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\Bus;

use Blabster\Infrastructure\Bus\CqrsBusInterface;
use Blabster\Application\Bus\Query\QueryInterface;
use Blabster\Application\Bus\Query\QueryResultInterface;

/**
 * @template TElement of QueryInterface
 * @template TResult of QueryResultInterface
 * 
 * @extends CqrsBusInterface<TElement,TResult>
 */
interface QueryBusInterface extends CqrsBusInterface
{
    /*_*/
}
