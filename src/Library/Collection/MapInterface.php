<?php

declare(strict_types=1);

namespace Blabster\Library\Collection;

use IteratorAggregate;

/**
 * @template TKey of array-key
 * @template TValue
 * @extends ArrayableInterface<TKey, TValue>
 * @extends IteratorAggregate<TKey, TValue>
 */
interface MapInterface extends ArrayableInterface, IteratorAggregate, InnerTypeInterface
{
    /*_*/
}