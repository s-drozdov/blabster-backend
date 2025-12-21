<?php

declare(strict_types=1);

namespace Blabster\Domain\Factory;

use Blabster\Domain\Entity\PowChallenge;
use Blabster\Domain\Helper\DateTime\DateTimeHelperInterface;
use Blabster\Domain\Helper\Uuid\UuidHelperInterface;
use Override;

final readonly class PowChallengeFactory implements PowChallengeFactoryInterface
{
    public function __construct(
        private UuidHelperInterface $uuidHelper,
        private DateTimeHelperInterface $dateTimeHelper,
        private int|null $ttlSeconds,
    ) {
        /*_*/
    }

    #[Override]
    public function create(int $difficulty): PowChallenge
    {
        return new PowChallenge(
            uuid: $this->uuidHelper->create(),
            prefix: bin2hex(random_bytes(16)),
            salt: bin2hex(random_bytes(16)),
            difficulty: $difficulty,
            expires_at: $this->dateTimeHelper->getExpiresAt($this->ttlSeconds),
        );
    }
}
