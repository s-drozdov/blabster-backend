<?php

declare(strict_types=1);

namespace Blabster\Domain\Repository;

use InvalidArgumentException;
use Blabster\Domain\Entity\Otp;
use Blabster\Domain\Entity\EntityInterface;
use Blabster\Domain\ValueObject\UuidInterface;

/**
 * @extends RepositoryInterface<Otp>
 */
interface OtpRepositoryInterface extends RepositoryInterface
{
    /**
     * @return Otp
     * @throws InvalidArgumentException
     */
    public function getByUuid(UuidInterface $uuid): EntityInterface;

    public function save(Otp $entity): void;
}
