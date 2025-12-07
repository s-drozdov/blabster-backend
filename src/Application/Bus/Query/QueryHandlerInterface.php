<?php

declare(strict_types=1);

namespace Blabster\Application\Bus\Query;

use Blabster\Application\Bus\CqrsHandlerInterface;

/**
 * @template TElement of QueryInterface
 * @template TResult of QueryResultInterface
 * 
 * @extends CqrsHandlerInterface<TElement,TResult>
 */
interface QueryHandlerInterface extends CqrsHandlerInterface
{
    /*_*/
}
