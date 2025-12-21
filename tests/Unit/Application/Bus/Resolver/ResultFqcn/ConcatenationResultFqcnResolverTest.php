<?php

declare(strict_types=1);

namespace Blabster\Tests\Unit\Application\Bus\Resolver\ResultFqcn;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\DataProvider;
use Blabster\Application\Bus\Resolver\ResultFqcn\ConcatenationResultFqcnResolver;

final class ConcatenationResultFqcnResolverTest extends TestCase
{
    #[Test]
    #[DataProvider('commandToResultProvider')]
    public function testResolve(string $fqcn, string $expected): void
    {
        // arrange
        $resolver = new ConcatenationResultFqcnResolver();

        // act
        $result = $resolver->resolve($fqcn);

        // assert
        self::assertSame($expected, $result);
    }

    public static function commandToResultProvider()
    {
        return [
            ['App\\Application\\Command\\CreateUserCommand', 'App\\Application\\Command\\CreateUserCommandResult'],
            ['App\\Something\\Test', 'App\\Something\\TestResult'],
        ];
    }
}
