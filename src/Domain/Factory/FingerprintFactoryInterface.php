<?php

declare(strict_types=1);

namespace Blabster\Domain\Factory;

use Blabster\Domain\Entity\Fingerprint;

interface FingerprintFactoryInterface extends FactoryInterface
{
    public function create(string $value): Fingerprint;
}
