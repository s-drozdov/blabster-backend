<?php

declare(strict_types=1);

namespace Blabster\Domain\Service\PowChallenge\Validation;

use InvalidArgumentException;
use Blabster\Domain\Service\ServiceInterface;
use Blabster\Domain\ValueObject\UuidInterface;

interface PowChallengeValidationServiceInterface extends ServiceInterface
{
    /**
     * @throws InvalidArgumentException
     */
    public function perform(UuidInterface $powChallengeUuid, string $nonce): void;
}
