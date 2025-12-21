<?php

declare(strict_types=1);

namespace Blabster\Domain\Service\Otp\Create;

use Blabster\Domain\Entity\Otp;
use Blabster\Domain\Service\ServiceInterface;

interface OtpCreateServiceInterface extends ServiceInterface
{
    public function perform(string $email): Otp;
}
