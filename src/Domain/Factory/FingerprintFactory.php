<?php

declare(strict_types=1);

namespace Blabster\Domain\Factory;

use Override;
use Blabster\Domain\Entity\Fingerprint;
use Blabster\Domain\Helper\Uuid\UuidHelperInterface;
use Blabster\Domain\Helper\DateTime\DateTimeHelperInterface;

final readonly class FingerprintFactory implements FingerprintFactoryInterface
{
    public function __construct(
        private UuidHelperInterface $uuidHelper,
        private DateTimeHelperInterface $dateTimeHelper,
        private int|null $ttlSeconds,
    ) {
        /*_*/
    }

    #[Override]
    public function create(string $value): Fingerprint
    {
        return new Fingerprint(
            uuid: $this->uuidHelper->create(),
            value: $value,
            expires_at: $this->dateTimeHelper->getExpiresAt($this->ttlSeconds),
        );
    }
}
