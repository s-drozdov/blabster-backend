<?php

declare(strict_types=1);

namespace Blabster\Domain\Repository\Filter;

use Blabster\Library\Pager\PagerInterface;

interface FilterInterface
{
    public function getPager(): ?PagerInterface;
}
