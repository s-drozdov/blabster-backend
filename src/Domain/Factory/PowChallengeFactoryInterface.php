<?php

declare(strict_types=1);

namespace Blabster\Domain\Factory;

use Blabster\Domain\Entity\PowChallenge;

interface PowChallengeFactoryInterface extends FactoryInterface
{
    public function create(int $difficulty): PowChallenge;
}
