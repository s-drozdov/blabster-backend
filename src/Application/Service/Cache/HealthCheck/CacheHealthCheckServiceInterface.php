<?php

declare(strict_types=1);

namespace Blabster\Application\Service\Cache\HealthCheck;

interface CacheHealthCheckServiceInterface
{
    public function perform(): void;
}
