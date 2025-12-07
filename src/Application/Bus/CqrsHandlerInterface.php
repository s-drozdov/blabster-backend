<?php

declare(strict_types=1);

namespace Blabster\Application\Bus;

use Exception;

/**
 * @template TElement of CqrsElementInterface
 * @template TResult of CqrsResultInterface
 */
interface CqrsHandlerInterface
{
    /**
     * @param TElement $element
     * 
     * @return TResult
     * @throws Exception
     */
    public function __invoke(CqrsElementInterface $element): CqrsResultInterface;
}
