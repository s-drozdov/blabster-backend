<?php

declare(strict_types=1);

namespace Blabster\Domain\Repository;

use InvalidArgumentException;
use Blabster\Domain\Entity\EntityInterface;
use Blabster\Domain\Entity\TurnsnileResult;

/**
 * @extends RepositoryInterface<TurnsnileResult>
 */
interface TurnsnileResultRepositoryInterface extends RepositoryInterface
{
    /**
     * @return TurnsnileResult
     * @throws InvalidArgumentException
     */
    public function getByUuid(string $turnsnileToken, ?string $clientRemoteIp = null): EntityInterface;
}
