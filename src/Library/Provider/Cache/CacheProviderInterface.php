<?php

declare(strict_types=1);

namespace Blabster\Library\Provider\Cache;

use RuntimeException;

interface CacheProviderInterface
{
    /**
     * @throws RuntimeException
     */
    public function get(string $key): mixed;

    /**
     * @throws RuntimeException
     */
    public function set(string $key, mixed $value, ?int $expireSeconds = null): void;

    /**
     * @throws RuntimeException
     */
    public function isSet(string $key): bool;

    /**
     * @throws RuntimeException
     */
    public function clear(): void;
}
