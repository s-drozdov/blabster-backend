<?php

declare(strict_types=1);

namespace Blabster\Domain\Service\PowChallenge\Create;

use Blabster\Domain\Entity\PowChallenge;
use Blabster\Domain\Factory\PowChallengeFactoryInterface;
use Blabster\Domain\Repository\PowChallengeRepositoryInterface;
use Override;

final readonly class PowChallengeCreateService implements PowChallengeCreateServiceInterface
{
    public function __construct(
        private PowChallengeFactoryInterface $powChallengeFactory,
        private PowChallengeRepositoryInterface $powChallengeRepository,
        private int $difficulty,
    ) {
        /*_*/
    }

    #[Override]
    public function perform(): PowChallenge
    {
        $powChallenge = $this->powChallengeFactory->create($this->difficulty);
        $this->powChallengeRepository->save($powChallenge);

        return $powChallenge;
    }
}
