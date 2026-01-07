<?php

declare(strict_types=1);

namespace Blabster\Tests\Unit\Application\UseCase\Query\Cache\HealthCheck;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Blabster\Application\UseCase\Query\Cache\HealthCheck\CacheHealthCheckQuery;
use Blabster\Application\Service\Cache\HealthCheck\CacheHealthCheckServiceInterface;
use Blabster\Application\UseCase\Query\Cache\HealthCheck\CacheHealthCheckQueryHandler;

final class CacheHealthCheckQueryHandlerTest extends TestCase
{
    #[Test]
    public function testInvokeSuccess(): void
    {
        // arrange
        $query = new CacheHealthCheckQuery();

        $cacheHealthCheckService = $this->createMock(CacheHealthCheckServiceInterface::class);
        $cacheHealthCheckService->expects(self::once())->method('perform');

        $handler = new CacheHealthCheckQueryHandler($cacheHealthCheckService);

        // act
        $handler($query);
    }
}
