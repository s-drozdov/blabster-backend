<?php

declare(strict_types=1);

namespace Blabster\Domain\Service\Otp\Create;

use Override;
use Blabster\Domain\Entity\Otp;
use Blabster\Domain\Factory\OtpFactoryInterface;
use Blabster\Domain\Repository\OtpRepositoryInterface;

final readonly class OtpCreateService implements OtpCreateServiceInterface
{
    public function __construct(
        private OtpFactoryInterface $otpFactory,
        private OtpRepositoryInterface $otpRepository,
    ) {
        /*_*/
    }

    #[Override]
    public function perform(string $email): Otp
    {
        $otp = $this->otpFactory->create($email);
        $this->otpRepository->save($otp);

        return $otp;
    }
}
