<?php

declare(strict_types=1);

namespace Blabster\Application\UseCase\Query\Cache\Dump;

use Override;
use Psr\SimpleCache\CacheInterface;
use Blabster\Application\Bus\CqrsElementInterface;
use Blabster\Application\Bus\Query\QueryHandlerInterface;
use Blabster\Application\UseCase\Query\Cache\Dump\CacheDumpQuery;

/**
 * @implements QueryHandlerInterface<CacheDumpQuery,CacheDumpQueryResult>
 */
final readonly class CacheDumpQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private CacheInterface $cache,
    ) {
        /*_*/
    }

    #[Override]
    public function __invoke(CqrsElementInterface $query): CacheDumpQueryResult
    {
        dump($this->cache->get($query->key));

        return new CacheDumpQueryResult();
    }
}
