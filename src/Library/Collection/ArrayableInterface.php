<?php

declare(strict_types=1);

namespace Blabster\Library\Collection;

use Traversable;

/**
 * @template TKey of array-key
 * @template TValue
 * @extends Traversable<TKey, TValue>
 */
interface ArrayableInterface extends Traversable
{   
    /**
     * @return array<TKey, TValue>
     */
    public function toArray(): array;
}
