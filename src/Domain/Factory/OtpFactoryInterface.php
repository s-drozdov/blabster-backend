<?php

declare(strict_types=1);

namespace Blabster\Domain\Factory;

use Blabster\Domain\Entity\Otp;

interface OtpFactoryInterface extends FactoryInterface
{
    public function create(string $email): Otp;
}
