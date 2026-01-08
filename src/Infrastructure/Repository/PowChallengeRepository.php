<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\Repository;

use Override;
use Psr\SimpleCache\CacheInterface;
use Blabster\Domain\Entity\PowChallenge;
use Blabster\Domain\Helper\String\StringHelperInterface;
use Blabster\Domain\Repository\PowChallengeRepositoryInterface;

final class PowChallengeRepository implements PowChallengeRepositoryInterface
{
    /** @use CachePersistable<PowChallenge> */
    use CachePersistable;

    public function __construct(
        private CacheInterface $cache,
        private StringHelperInterface $stringHelper,
        private int|null $ttlSeconds,
    ) {
        /*_*/
    }

    #[Override]
    private function getCache(): CacheInterface
    {
        return $this->cache;
    }

    #[Override]
    private function getTtl(): ?int
    {
        return $this->ttlSeconds;
    }

    #[Override]
    private function getStringHelper(): StringHelperInterface
    {
        return $this->stringHelper;
    }

    #[Override]
    private function getEntityFqcn(): string
    {
        return PowChallenge::class;
    }
}
