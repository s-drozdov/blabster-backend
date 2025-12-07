<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\Bus;

use Blabster\Infrastructure\Bus\CqrsBusInterface;
use Blabster\Application\Bus\Command\CommandInterface;
use Blabster\Application\Bus\Command\CommandResultInterface;

/**
 * @template TElement of CommandInterface
 * @template TResult of CommandResultInterface
 * 
 * @extends CqrsBusInterface<TElement,TResult>
 */
interface CommandBusInterface extends CqrsBusInterface
{
    /*_*/
}
