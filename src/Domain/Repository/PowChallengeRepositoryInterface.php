<?php

declare(strict_types=1);

namespace Blabster\Domain\Repository;

use Blabster\Domain\Entity\EntityInterface;
use InvalidArgumentException;
use Blabster\Domain\Entity\PowChallenge;
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
    public function get(UuidInterface $uuid): EntityInterface;

    public function save(PowChallenge $entity): void;
}
