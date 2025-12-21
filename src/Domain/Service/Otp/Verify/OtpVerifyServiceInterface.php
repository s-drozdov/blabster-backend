<?php

declare(strict_types=1);

namespace Blabster\Domain\Service\Otp\Verify;

use Blabster\Domain\Service\ServiceInterface;
use Blabster\Domain\ValueObject\UuidInterface;

interface OtpVerifyServiceInterface extends ServiceInterface
{
    public function perform(string $email, UuidInterface $otpUuid, string $otpCode): void;
}
