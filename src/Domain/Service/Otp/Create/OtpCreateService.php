<?php

declare(strict_types=1);

namespace Blabster\Domain\Service\Otp\Create;

use Blabster\Domain\Entity\Otp;
use Blabster\Domain\Factory\OtpFactory;
use Blabster\Domain\Service\ServiceInterface;
use Blabster\Domain\Repository\OtpRepositoryInterface;

final readonly class OtpCreateService implements ServiceInterface
{
    public function __construct(
        private OtpFactory $otpFactory,
        private OtpRepositoryInterface $otpRepository,
    ) {
        /*_*/
    }

    public function perform(string $email): Otp
    {
        $otp = $this->otpFactory->create($email);
        $this->otpRepository->save($otp);

        return $otp;
    }
}
