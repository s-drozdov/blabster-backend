<?php

declare(strict_types=1);

namespace Blabster\Domain\Repository;

use RuntimeException;
use InvalidArgumentException;
use Blabster\Domain\Entity\PowChallenge;
use Blabster\Domain\Entity\EntityInterface;
use Blabster\Domain\ValueObject\UuidInterface;

/**
 * @extends RepositoryInterface<PowChallenge>
 */
interface PowChallengeRepositoryInterface extends RepositoryInterface
{
    /**
     * @return PowChallenge
     * @throws InvalidArgumentException
     */
    public function getByUuid(UuidInterface $uuid): EntityInterface;

    /**
     * @throws RuntimeException
     */
    public function save(PowChallenge $entity): void;
}
