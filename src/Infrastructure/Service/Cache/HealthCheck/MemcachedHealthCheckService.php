<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\Service\Cache\HealthCheck;

use Memcached;
use RuntimeException;
use Blabster\Application\Service\Cache\HealthCheck\CacheHealthCheckServiceInterface;
use Override;

final class MemcachedHealthCheckService implements CacheHealthCheckServiceInterface
{
    private const string ERROR_MEMCACHED_UNAVAILABLE = 'Memcached is unavailable';

    public function __construct(
        private Memcached $memcached,
    ) {
        /*_*/
    }

    #[Override]
    public function perform(): void
    {
        $versionList = $this->memcached->getVersion();

        if (empty($versionList)) {
            throw new RuntimeException(self::ERROR_MEMCACHED_UNAVAILABLE);
        }
    }
}
