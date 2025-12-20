<?php

declare(strict_types=1);

namespace Blabster\Library\Pager;

use Override;

final readonly class Pager implements PagerInterface
{
    public function __construct(
        public int $page,
        public int $perPage,
        public ?int $total = null,
    ) {
        /*_*/
    }

    #[Override]
    public function getPage(): int
    {
        return $this->page;
    }

    #[Override]
    public function getTotal(): ?int
    {
        return $this->total;
    }

    #[Override]
    public function getOffset(): int
    {
        if ($this->page === PagerInterface::DEFAULT_PAGE) {
            return PagerInterface::DEFAULT_OFFSET;
        }

        return $this->perPage * ($this->page - PagerInterface::DEFAULT_PAGE);
    }

    #[Override]
    public function getLimit(): int
    {
        return $this->perPage;
    }
}
