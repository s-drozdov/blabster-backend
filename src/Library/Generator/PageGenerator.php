<?php

declare(strict_types=1);

namespace Blabster\Library\Generator;

use Generator;
use Override;
use Blabster\Domain\Repository\Filter\Pager;
use Blabster\Domain\Repository\Filter\PagerInterface;
use Blabster\Library\Generator\PageGeneratorInterface;

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
