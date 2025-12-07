<?php

declare(strict_types=1);

namespace Blabster\Application\Bus\Command;

use Blabster\Application\Bus\CqrsHandlerInterface;

/**
 * @template TElement of CommandInterface
 * @template TResult of CommandResultInterface
 * 
 * @extends CqrsHandlerInterface<TElement,TResult>
 */
interface CommandHandlerInterface extends CqrsHandlerInterface
{
    /*_*/
}
