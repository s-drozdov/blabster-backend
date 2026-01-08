<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\Repository;

use Override;
use RuntimeException;
use Psr\SimpleCache\CacheInterface;
use Blabster\Domain\Entity\Fingerprint;
use Blabster\Domain\Helper\String\StringHelperInterface;
use Blabster\Domain\Repository\FingerprintRepositoryInterface;

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
        $isSuccess = $this->cache->set(
            $this->stringHelper->getSlugForClass($entity->getValue(), $entity),
            $entity,
            $this->ttlSeconds,
        );

        if ($isSuccess) {
            return;
        }

        throw new RuntimeException(
            sprintf(
                self::ERROR_NOT_FOUND, 
                $this->stringHelper->getClassShortName($entity), 
                $entity->getUuid(),
            ),
        );
    }
}
