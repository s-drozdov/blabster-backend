<?php

declare(strict_types=1);

namespace Blabster\Domain\Service\PowChallenge\Create;

use Blabster\Domain\Entity\PowChallenge;
use Blabster\Domain\Factory\PowChallengeFactory;
use Blabster\Domain\Repository\PowChallengeRepositoryInterface;
use Blabster\Domain\Service\ServiceInterface;

final readonly class PowChallengeCreateService implements ServiceInterface
{
    public function __construct(
        private PowChallengeFactory $powChallengeFactory,
        private PowChallengeRepositoryInterface $powChallengeRepository,
        private int $difficulty,
    ) {
        /*_*/
    }

    public function perform(): PowChallenge
    {
        $powChallenge = $this->powChallengeFactory->create($this->difficulty);
        $this->powChallengeRepository->save($powChallenge);

        return $powChallenge;
    }
}
