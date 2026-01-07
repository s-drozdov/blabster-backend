<?php

declare(strict_types=1);

namespace Blabster\Application\UseCase\Query\Cache\HealthCheck;

use Override;
use Blabster\Application\Bus\CqrsElementInterface;
use Blabster\Application\Bus\Query\QueryHandlerInterface;
use Blabster\Application\Service\Cache\HealthCheck\CacheHealthCheckServiceInterface;
use Blabster\Application\UseCase\Query\Cache\HealthCheck\CacheHealthCheckQuery;
use Blabster\Application\UseCase\Query\Cache\HealthCheck\CacheHealthCheckQueryResult;

/**
 * @implements QueryHandlerInterface<CacheHealthCheckQuery,CacheHealthCheckQueryResult>
 */
final readonly class CacheHealthCheckQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private CacheHealthCheckServiceInterface $cacheHealthCheckService,
    ) {
        /*_*/
    }

    #[Override]
    public function __invoke(CqrsElementInterface $query): CacheHealthCheckQueryResult
    {
        $this->cacheHealthCheckService->perform();

        return new CacheHealthCheckQueryResult();
    }
}
