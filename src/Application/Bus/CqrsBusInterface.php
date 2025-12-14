<?php

declare(strict_types=1);

namespace Blabster\Application\Bus;

use Blabster\Application\Bus\CqrsResultInterface;
use Blabster\Application\Bus\CqrsElementInterface;
use Throwable;

/**
 * @template TElement of CqrsElementInterface
 * @template TResult of CqrsResultInterface
 */
interface CqrsBusInterface extends BusInterface
{
    /**
     * @param TElement $element
     * 
     * @return TResult
     * @throws Throwable
     */
    public function execute($element): mixed;
}
