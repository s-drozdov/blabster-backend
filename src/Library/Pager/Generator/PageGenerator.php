<?php

declare(strict_types=1);

namespace Blabster\Library\Pager\Generator;

use Override;
use Generator;
use Blabster\Library\Pager\Pager;
use Blabster\Library\Pager\PagerInterface;

final class PageGenerator implements PageGeneratorInterface
{
    private const int DEFAULT_OFFSET = 0;

    #[Override]
    public function generate(int $total, int $perPage = PagerInterface::DEFAULT_LIMIT): Generator
    {
        $offset = self::DEFAULT_OFFSET;

        while ($offset < $total) {
            yield new Pager(
                page: (int) floor($offset / $perPage) + 1,
                perPage: $perPage,
                total: $total,
            );

            $offset += $perPage;
        }
    }
}
