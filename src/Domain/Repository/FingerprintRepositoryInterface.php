<?php

declare(strict_types=1);

namespace Blabster\Domain\Repository;

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

    public function save(Fingerprint $entity): void;
}
