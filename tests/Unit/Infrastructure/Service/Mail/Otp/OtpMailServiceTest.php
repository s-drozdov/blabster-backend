<?php

declare(strict_types=1);

namespace Blabster\Tests\Unit\Infrastructure\Service\Mail\Otp;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Symfony\Component\Mailer\MailerInterface;
use Blabster\Infrastructure\Service\Mail\Otp\OtpMailService;

final class OtpMailServiceTest extends TestCase
{
    private const int EXPIRATION_SECONDS = 90;
    private const string SENDER_EMAIL = 'sender@example.com';
    private const string EMAIL_SUBJECT = 'Test subject';
    private const string TEMPLATE_HTML = '<html></html>';
    private const string TEMPLATE_TEXT = 'text';
    private const string MESSAGE_LOCALE = 'en';
    private const string REPLY_TO_EMAIL = 't@t.com';
    private const string OTP_CODE = '12345';
    private const string TARGET_EMAIL = 'target@example.com';

    #[Test]
    public function testMail(): void
    {
        // arrange
        $mailer = $this->createMock(MailerInterface::class);

        $mailer
            ->expects(self::once())
            ->method('send')
        ;

        $service = new OtpMailService(
            $mailer,
            self::EXPIRATION_SECONDS,
            self::SENDER_EMAIL,
            self::EMAIL_SUBJECT,
            self::TEMPLATE_HTML,
            self::TEMPLATE_TEXT,
            self::MESSAGE_LOCALE,
            self::REPLY_TO_EMAIL,
        );

        // act
        $service->perform(self::OTP_CODE, self::TARGET_EMAIL);
    }
}
