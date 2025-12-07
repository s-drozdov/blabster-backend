<?php

declare(strict_types=1);

namespace Blabster\Library\Collection;

use IteratorAggregate;

/**
 * @template T
 * @extends ArrayableInterface<array-key, T>
 * @extends IteratorAggregate<array-key, T>
 */
interface ListInterface extends ArrayableInterface, IteratorAggregate, InnerTypeInterface
{
    /*_*/
}