<?php

declare(strict_types=1);

namespace Blabster\Application\Service\Mail\Otp;

use Blabster\Application\Service\ServiceInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

interface OtpMailServiceInterface extends ServiceInterface
{
    /**
     * @throws TransportExceptionInterface
     */
    public function perform(string $otpCode, string $email): void;
}
