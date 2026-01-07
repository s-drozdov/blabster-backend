<?php

declare(strict_types=1);

namespace Blabster\Tests\Unit\Infrastructure\Service\Cache\HealthCheck;

use Memcached;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Blabster\Infrastructure\Service\Cache\HealthCheck\MemcachedHealthCheckService;
use RuntimeException;

final class MemcachedHealthCheckServiceTest extends TestCase
{
    private const array MEMCACHED_VERSION = ['some-memcached-host-1:11211' => 'some-version'];

    #[Test]
    public function testMemcachedIsAvailable(): void
    {
        // arrange
        $memcached = $this->createMock(Memcached::class);

        $memcached
            ->expects(self::once())
            ->method('getVersion')
            ->willReturn(self::MEMCACHED_VERSION)
        ;

        $service = new MemcachedHealthCheckService($memcached);

        // act
        $service->perform();

        // assert
        self::assertTrue(true); // test does not throw
    }

    #[Test]
    public function testMemcachedIsNotAvailable(): void
    {
        // arrange
        $memcached = $this->createMock(Memcached::class);

        $memcached
            ->expects(self::once())
            ->method('getVersion')
            ->willReturn([])
        ;

        $service = new MemcachedHealthCheckService($memcached);

        $this->expectException(RuntimeException::class);

        // act
        $service->perform();
    }
}
