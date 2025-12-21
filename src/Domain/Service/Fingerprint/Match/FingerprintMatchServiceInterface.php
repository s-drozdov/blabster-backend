<?php

declare(strict_types=1);

namespace Blabster\Domain\Service\Fingerprint\Match;

use InvalidArgumentException;
use Blabster\Domain\Entity\Fingerprint;
use Blabster\Domain\Service\ServiceInterface;

interface FingerprintMatchServiceInterface extends ServiceInterface
{
    /**
     * @throws InvalidArgumentException
     */
    public function perform(string $value): ?Fingerprint;
}
