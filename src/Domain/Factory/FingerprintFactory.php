<?php

declare(strict_types=1);

namespace Blabster\Domain\Factory;

use Blabster\Domain\Entity\Fingerprint;
use Blabster\Library\Helper\DateTime\DateTimeHelperInterface;
use Blabster\Library\Helper\Uuid\UuidHelperInterface;

final readonly class FingerprintFactory implements FactoryInterface
{
    public function __construct(
        private UuidHelperInterface $uuidHelper,
        private DateTimeHelperInterface $dateTimeHelper,
        private int|null $ttlSeconds,
    ) {
        /*_*/
    }

    public function create(string $value): Fingerprint
    {
        return new Fingerprint(
            uuid: $this->uuidHelper->create(),
            value: $value,
            expires_at: $this->dateTimeHelper->getExpiresAt($this->ttlSeconds),
        );
    }
}
