<?php

declare(strict_types=1);

namespace Blabster\Domain\Factory;

use Blabster\Domain\Entity\Otp;
use Blabster\Domain\Helper\Uuid\UuidHelperInterface;

final readonly class OtpFactory implements FactoryInterface
{
    public function __construct(
        private UuidHelperInterface $uuidHelper,
    ) {
        /*_*/
    }

    public function create(string $email): Otp
    {
        return new Otp(
            uuid: $this->uuidHelper->create(),
            email: $email,
            code: sprintf('%05d', random_int(0, 99999)),
        );
    }
}
