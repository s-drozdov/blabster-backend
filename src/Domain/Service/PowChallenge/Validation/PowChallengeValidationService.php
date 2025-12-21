<?php

declare(strict_types=1);

namespace Blabster\Domain\Service\PowChallenge\Validation;

use Override;
use Webmozart\Assert\Assert;
use Blabster\Domain\ValueObject\UuidInterface;
use Blabster\Domain\Repository\PowChallengeRepositoryInterface;

final readonly class PowChallengeValidationService implements PowChallengeValidationServiceInterface
{
    private const string ALGORYTHM = 'sha256';
    private const string VALIDATION_ERROR = 'Validation proof-of-work was not passed';

    public function __construct(
        private PowChallengeRepositoryInterface $powChallengeRepository,
    ) {
        /*_*/
    }

    #[Override]
    public function perform(UuidInterface $powChallengeUuid, string $nonce): void
    {
        $powChallenge = $this->powChallengeRepository->getByUuid($powChallengeUuid);

        $prefix = str_repeat('0', $powChallenge->getDifficulty());
        $hash = hash(self::ALGORYTHM, $powChallenge->getPrefix() . $powChallenge->getSalt() . $nonce);

        Assert::eq(
            substr($hash, 0, $powChallenge->getDifficulty()),
            $prefix,
            self::VALIDATION_ERROR,
        );
    }
}
