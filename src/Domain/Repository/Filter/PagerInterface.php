<?php

declare(strict_types=1);

namespace Blabster\Domain\Repository\Filter;

interface PagerInterface
{
    public const int DEFAULT_PAGE = 1;
    public const int DEFAULT_OFFSET = 0;
    public const int DEFAULT_LIMIT = 10;

    public function getPage(): int;

    public function getTotal(): ?int;

    public function getOffset(): int;

    public function getLimit(): int;
}
