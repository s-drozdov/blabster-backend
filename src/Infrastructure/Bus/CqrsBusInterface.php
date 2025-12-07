<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\Bus;

use Throwable;
use Blabster\Infrastructure\Bus\BusInterface;
use Blabster\Application\Bus\CqrsResultInterface;
use Blabster\Application\Bus\CqrsElementInterface;

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
