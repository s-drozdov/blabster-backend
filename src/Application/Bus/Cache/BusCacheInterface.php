<?php

declare(strict_types=1);

namespace Blabster\Application\Bus\Cache;

use RuntimeException;
use Blabster\Application\Bus\CqrsResultInterface;
use Blabster\Application\Bus\CqrsElementInterface;

interface BusCacheInterface
{
    /**
     * @param class-string|null $resultFqcn
     * 
     * @throws RuntimeException
     */
    public function get(CqrsElementInterface $element, ?string $resultFqcn = null): ?CqrsResultInterface;

    /**
     * @throws RuntimeException
     */
    public function set(CqrsElementInterface $element, CqrsResultInterface $result, ?int $expireSeconds = null): void;

    /**
     * @throws RuntimeException
     */
    public function clear(): void;
}
