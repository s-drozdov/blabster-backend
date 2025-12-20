<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\Repository;

use Blabster\Domain\Entity\Fingerprint;
use Psr\SimpleCache\CacheInterface;
use Blabster\Domain\Repository\FingerprintRepositoryInterface;
use Blabster\Domain\Helper\String\StringHelperInterface;
use Override;

final class FingerprintRepository implements FingerprintRepositoryInterface
{
    public function __construct(
        private CacheInterface $cache,
        private StringHelperInterface $stringHelper,
        private int|null $ttlSeconds,
    ) {
        /*_*/
    }

    #[Override]
    public function findByValue(string $value): ?Fingerprint
    {
        /** @var Fingerprint|null $entity */
        $entity = $this->cache->get(
            $this->stringHelper->getSlugForClass($value, Fingerprint::class),
        );

        return $entity;
    }

    #[Override]
    public function save(Fingerprint $entity): void
    {
        $this->cache->set(
            $this->stringHelper->getSlugForClass($entity->getValue(), $entity),
            $entity,
            $this->ttlSeconds,
        );
    }
}
