<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\Service\Mail;

use Override;
use Symfony\Component\Mime\RawMessage;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Blabster\Application\Service\Otp\Mail\OtpMailServiceInterface;

final readonly class OtpMailService implements OtpMailServiceInterface
{
    public function __construct(
        private MailerInterface $mailer,
        private int $expirationSeconds,
        private string $senderEmail,
        private string $emailSubject,
        private string $templateHtml,
        private string $templateText,
        private string $messageLocale,
        private string $replyToEmail,
    ) {
        /*_*/
    }

    #[Override]
    public function perform(string $otpCode, string $email): void
    {
        $this->mailer->send(
            $this->buildEmail($otpCode, $email),
        );
    }

    private function buildEmail(string $otpCode, string $email): RawMessage
    {
        $otpCode = str_pad($otpCode, 5, '0');
        /** @psalm-suppress PossiblyUndefinedArrayOffset */
        [$otp0, $otp1, $otp2, $otp3, $otp4] = str_split($otpCode);

        return (new TemplatedEmail())
            ->from($this->senderEmail)
            ->to($email)
            ->replyTo($this->replyToEmail)
            ->subject($this->emailSubject)
            ->htmlTemplate($this->templateHtml)
            ->textTemplate($this->templateText)
            ->locale($this->messageLocale)
            ->context([
                'otp0' => $otp0,
                'otp1' => $otp1,
                'otp2' => $otp2,
                'otp3' => $otp3,
                'otp4' => $otp4,
                'expirationMinutes' => (int) floor($this->expirationSeconds / 60),
            ]);
    }
}
