<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\Factory\Cache;

use Memcached;
use RuntimeException;

final class MemcachedFactory
{
    private const string ERROR_INVALID_DSN = 'Invalid memcached dsn';

    public function create(string $dsn): Memcached
    {
        $memcached = new Memcached();

        if (!str_contains($dsn, 'memcached://')) {
            throw new RuntimeException(self::ERROR_INVALID_DSN);
        }

        $url = parse_url($dsn);

        if (!isset($url['host'])) {
            throw new RuntimeException(self::ERROR_INVALID_DSN);
        }

        $memcached->addServer(
            $url['host'],
            $url['port'] ?? 11211
        );

        return $memcached;
    }
}
