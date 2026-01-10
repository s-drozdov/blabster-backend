<?php

declare(strict_types=1);

namespace Blabster\Domain\Entity;

use Override;
use Blabster\Domain\ValueObject\UuidInterface;

/**
 * @psalm-suppress ClassMustBeFinal The class cannot be final because it is used as a test double in PHPUnit
 */
class Otp implements EntityInterface
{
    public function __construct(
        private UuidInterface $uuid,
        private string $email,
        private string $code,
    ) {
        /*_*/
    }

    #[Override]
    public function getUuid(): UuidInterface
    {
        return $this->uuid;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getCode(): string
    {
        return $this->code;
    }
}
