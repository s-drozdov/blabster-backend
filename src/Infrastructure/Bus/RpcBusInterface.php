<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\Bus;

use Blabster\Application\Bus\CqrsElementInterface;
use Blabster\Application\Bus\CqrsResultInterface;

/**
 * @template TElement of CqrsElementInterface
 * @template TResult of CqrsResultInterface
 * 
 * @extends CqrsBusInterface<TElement, TResult>
 */
interface RpcBusInterface extends CqrsBusInterface
{
    /*_*/
}
