<?php

declare(strict_types=1);

namespace Blabster\Tests\Unit\Library\Pager;

use PHPUnit\Framework\TestCase;
use Blabster\Library\Pager\Pager;
use PHPUnit\Framework\Attributes\Test;
use Blabster\Library\Pager\PagerInterface;

final class PagerTest extends TestCase
{
    #[Test]
    public function testGetPage(): void
    {
        // act
        $pager = new Pager(page: 3, perPage: 10);

        // assert
        self::assertSame(3, $pager->getPage());
    }

    #[Test]
    public function testGetTotalWhenProvided(): void
    {
        // act
        $pager = new Pager(page: 1, perPage: 10, total: 95);

        // assert
        self::assertSame(95, $pager->getTotal());
    }

    #[Test]
    public function testGetTotalWhenNull(): void
    {
        // act
        $pager = new Pager(page: 1, perPage: 10);

        // assert
        self::assertNull($pager->getTotal());
    }

    #[Test]
    public function testGetLimit(): void
    {
        // act
        $pager = new Pager(page: 1, perPage: 25);

        // assert
        self::assertSame(25, $pager->getLimit());
    }

    #[Test]
    public function testGetOffsetForDefaultPage(): void
    {
        // act
        $pager = new Pager(
            page: PagerInterface::DEFAULT_PAGE,
            perPage: 10
        );

        // assert
        self::assertSame(
            PagerInterface::DEFAULT_OFFSET,
            $pager->getOffset()
        );
    }

    #[Test]
    public function testGetOffsetForSecondPage(): void
    {
        // act
        $pager = new Pager(page: 2, perPage: 10);

        // assert
        self::assertSame(10, $pager->getOffset());
    }

    #[Test]
    public function testGetOffsetForArbitraryPage(): void
    {
        // act
        $pager = new Pager(page: 5, perPage: 20);

        // assert
        self::assertSame(80, $pager->getOffset());
    }
}
