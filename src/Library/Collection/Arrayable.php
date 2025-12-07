<?php

declare(strict_types=1);

namespace Blabster\Library\Collection;

use ArrayIterator;

/**
 * @template TKey of array-key
 * @template TValue
 * @implements IteratorAggregate<TKey,TValue>
 */
trait Arrayable
{   
    /**
     * @return array<TKey,TValue>
     */
    abstract public function toArray(): array;

    /**
     * @return ArrayIterator<TKey,TValue>
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator(
            $this->toArray(),
        );
    }
}
