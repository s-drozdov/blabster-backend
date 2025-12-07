<?php

declare(strict_types=1);

namespace Blabster\Library\Generator;

use Generator;
use Blabster\Domain\Repository\Filter\PagerInterface;

interface PageGeneratorInterface
{
    /**
     * @return Generator<array-key, PagerInterface, void, void>
     */
    public function generate(int $total, int $perPage = PagerInterface::DEFAULT_LIMIT): Generator;
}
