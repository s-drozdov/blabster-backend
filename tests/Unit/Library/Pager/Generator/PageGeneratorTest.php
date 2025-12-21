<?php

declare(strict_types=1);

namespace Blabster\Tests\Unit\Library\Pager\Generator;

use PHPUnit\Framework\TestCase;
use Blabster\Library\Pager\Pager;
use PHPUnit\Framework\Attributes\Test;
use Blabster\Library\Pager\PagerInterface;
use Blabster\Library\Pager\Generator\PageGenerator;

final class PageGeneratorTest extends TestCase
{
    #[Test]
    public function testGenerateSinglePageWhenTotalLessThanPerPage(): void
    {
        // arrange
        $generator = new PageGenerator();

        // act
        $pages = iterator_to_array(
            $generator->generate(total: 5, perPage: 10)
        );

        // assert
        self::assertCount(1, $pages);

        /** @var Pager $pager */
        $pager = $pages[0];

        self::assertSame(1, $pager->getPage());
        self::assertSame(10, $pager->getLimit());
        self::assertSame(5, $pager->getTotal());
    }

    #[Test]
    public function testGenerateMultiplePages(): void
    {
        // arrange
        $generator = new PageGenerator();

        // act
        $pages = iterator_to_array(
            $generator->generate(total: 25, perPage: 10)
        );

        // assert
        self::assertCount(3, $pages);

        self::assertSame(1, $pages[0]->getPage());
        self::assertSame(2, $pages[1]->getPage());
        self::assertSame(3, $pages[2]->getPage());

        foreach ($pages as $pager) {
            self::assertSame(10, $pager->getLimit());
            self::assertSame(25, $pager->getTotal());
        }
    }

    #[Test]
    public function testGenerateUsesDefaultPerPage(): void
    {
        // arrange
        $generator = new PageGenerator();

        // act
        $pages = iterator_to_array(
            $generator->generate(total: PagerInterface::DEFAULT_LIMIT * 2)
        );

        // assert
        self::assertCount(2, $pages);

        self::assertSame(1, $pages[0]->getPage());
        self::assertSame(2, $pages[1]->getPage());

        self::assertSame(
            PagerInterface::DEFAULT_LIMIT,
            $pages[0]->getLimit()
        );
    }

    #[Test]
    public function testGenerateReturnsEmptyGeneratorWhenTotalIsZero(): void
    {
        // arrange
        $generator = new PageGenerator();

        // act
        $pages = iterator_to_array(
            $generator->generate(total: 0, perPage: 10)
        );

        // assert
        self::assertCount(0, $pages);
    }

    #[Test]
    public function testEachGeneratedItemIsPagerInstance(): void
    {
        // arrange
        $generator = new PageGenerator();

        // act
        $iterator = $generator->generate(total: 30, perPage: 10);

        // assert
        foreach ($iterator as $pager) {
            self::assertInstanceOf(Pager::class, $pager);
        }
    }
}
