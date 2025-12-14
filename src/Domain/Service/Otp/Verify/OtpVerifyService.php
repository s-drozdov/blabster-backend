<?php

declare(strict_types=1);

namespace Blabster\Domain\Service\Otp\Verify;

use Webmozart\Assert\Assert;
use Blabster\Domain\Service\ServiceInterface;
use Blabster\Domain\ValueObject\UuidInterface;
use Blabster\Domain\Repository\OtpRepositoryInterface;

final readonly class OtpVerifyService implements ServiceInterface
{
    private const string ERROR_EMAIL_MISMATCH = 'OTP verification error. Email you have provided is not match with OTP initial email.';
    private const string ERROR_CODE_MISMATCH = 'OTP verification error. Wrong OTP code.';

    public function __construct(
        private OtpRepositoryInterface $otpRepository,
    ) {
        /*_*/
    }

    public function perform(string $email, UuidInterface $otpUuid, string $otpCode): void
    {
        $otp = $this->otpRepository->getByUuid($otpUuid);

        Assert::eq($otp->getEmail(), $email, self::ERROR_EMAIL_MISMATCH);
        Assert::eq($otp->getCode(), $otpCode, self::ERROR_CODE_MISMATCH);
    }
}
