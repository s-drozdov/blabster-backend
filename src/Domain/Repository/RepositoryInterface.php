<?php

declare(strict_types=1);

namespace Blabster\Domain\Repository;

use Blabster\Domain\Entity\EntityInterface;

/**
 * @template T of EntityInterface
 */
interface RepositoryInterface
{
    public const string ERROR_NOT_FOUND = '%s with uuid %s is not found';
}
