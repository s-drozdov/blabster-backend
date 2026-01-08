<?php

declare(strict_types=1);

namespace Blabster\Domain\Repository;

use RuntimeException;
use Blabster\Domain\Entity\Fingerprint;
use Blabster\Domain\Entity\EntityInterface;

/**
 * @extends RepositoryInterface<Fingerprint>
 */
interface FingerprintRepositoryInterface extends RepositoryInterface
{
    /**
     * @return Fingerprint|null
     */
    public function findByValue(string $value): ?EntityInterface;

    /**
     * @throws RuntimeException
     */
    public function save(Fingerprint $entity): void;
}
