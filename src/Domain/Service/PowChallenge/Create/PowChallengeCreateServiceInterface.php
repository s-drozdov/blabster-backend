<?php

declare(strict_types=1);

namespace Blabster\Domain\Service\PowChallenge\Create;

use Blabster\Domain\Entity\PowChallenge;
use Blabster\Domain\Service\ServiceInterface;

interface PowChallengeCreateServiceInterface extends ServiceInterface
{
    public function perform(): PowChallenge;
}
