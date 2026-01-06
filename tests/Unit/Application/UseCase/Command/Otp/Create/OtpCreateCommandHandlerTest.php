<?php

declare(strict_types=1);

namespace Blabster\Tests\Unit\Application\UseCase\Command\Otp\Create;

use DateTimeImmutable;
use Blabster\Domain\Entity\Otp;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Blabster\Domain\Entity\Fingerprint;
use PHPUnit\Framework\Attributes\Before;
use Blabster\Domain\Helper\Uuid\UuidHelperInterface;
use Blabster\Infrastructure\Helper\Uuid\RamseyUuidHelper;
use Blabster\Library\SDK\Turnstile\TurnstileSdkInterface;
use Blabster\Library\SDK\Turnstile\Response\TurnstileResultDto;
use Blabster\Domain\Service\Otp\Create\OtpCreateServiceInterface;
use Blabster\Application\Service\Otp\Mail\OtpMailServiceInterface;
use Blabster\Application\UseCase\Command\Otp\Create\OtpCreateCommand;
use Blabster\Application\UseCase\Command\Otp\Create\OtpCreateCommandHandler;
use Blabster\Domain\Service\Fingerprint\Match\FingerprintMatchServiceInterface;
use Blabster\Domain\Service\PowChallenge\Validation\PowChallengeValidationServiceInterface;
use InvalidArgumentException;

final class OtpCreateCommandHandlerTest extends TestCase
{
    private const string EMAIL = 'test@test.com';
    private const string FINGERPRINT_VALUE = 'fingerprint';
    private const string POW_CHALLENGE_NONCE = '000abc';
    private const string TURNSTILE_TOKEN = 'turnstile-token';
    private const string UUID_STRING = '123e4567-e89b-12d3-a456-426614174000';
    private const string OTP_VALUE = '12345';
    private const string HOST = 'example.com';
    private const bool IS_TURNSTILE_VALIDATION_ENABLED = true;

    private UuidHelperInterface $uuidHelper;
    
    #[Before]
    public function before(): void
    {
        $this->uuidHelper = new RamseyUuidHelper();
    }

    #[Test]
    public function testHandleWithNotEmptyExpiresAt()
    {
        // arrange
        $command = new OtpCreateCommand(
            email: self::EMAIL,
            pow_challenge_uuid: $this->uuidHelper->create(),
            pow_challenge_nonce: self::POW_CHALLENGE_NONCE,
            fingerprint: self::FINGERPRINT_VALUE,
            turnstile_token: self::TURNSTILE_TOKEN,
        );

        $expiresAt = new DateTimeImmutable('+1 hour');
        
        $fingerprint = $this->createStub(Fingerprint::class);
        $fingerprint->method('getExpiresAt')->willReturn($expiresAt);

        $fingerprintMatchService = $this->createMock(FingerprintMatchServiceInterface::class);

        $fingerprintMatchService
            ->expects(self::once())
            ->method('perform')
            ->with($command->fingerprint)
            ->willReturn($fingerprint)
        ;

        $handler = new OtpCreateCommandHandler(
            $this->createStub(PowChallengeValidationServiceInterface::class),
            $fingerprintMatchService,
            $this->createStub(TurnstileSdkInterface::class),
            $this->createStub(OtpCreateServiceInterface::class),
            $this->createStub(OtpMailServiceInterface::class),
            self::IS_TURNSTILE_VALIDATION_ENABLED,
        );

        // act
        $handler($command);
    }
    
    #[Test]
    public function testHandleWithEmptyExpiresAt()
    {
        // arrange
        $command = new OtpCreateCommand(
            email: self::EMAIL,
            pow_challenge_uuid: $this->uuidHelper->create(),
            pow_challenge_nonce: self::POW_CHALLENGE_NONCE,
            fingerprint: self::FINGERPRINT_VALUE,
            turnstile_token: self::TURNSTILE_TOKEN,
        );

        $powChallengeValidationService = $this->createMock(PowChallengeValidationServiceInterface::class);
        $powChallengeValidationService->expects(self::once())->method('perform');

        $fingerprint = $this->createStub(Fingerprint::class);
        $fingerprint->method('getExpiresAt')->willReturn(null);

        $fingerprintMatchService = $this->createMock(FingerprintMatchServiceInterface::class);

        $fingerprintMatchService
            ->expects(self::once())
            ->method('perform')
            ->with($command->fingerprint)
            ->willReturn($fingerprint)
        ;

        $turnstileResultDto = new TurnstileResultDto(
            success: true,
            challenge_ts: new DateTimeImmutable(),
            hostname: self::HOST,
        );

        $turnstileSdk = $this->createMock(TurnstileSdkInterface::class);
        $turnstileSdk
            ->expects(self::once())
            ->method('getResult')
            ->with($command->turnstile_token)
            ->willReturn($turnstileResultDto)
        ;

        $otp = $this->createStub(Otp::class);
        $otp->method('getUuid')->willReturn($this->uuidHelper->fromString(self::UUID_STRING));
        $otp->method('getCode')->willReturn(self::OTP_VALUE);
        $otp->method('getEmail')->willReturn(self::EMAIL);

        $otpCreateService = $this->createMock(OtpCreateServiceInterface::class);
        $otpCreateService
            ->expects(self::once())
            ->method('perform')
            ->with($command->email)
            ->willReturn($otp)
        ;

        $otpMailService = $this->createMock(OtpMailServiceInterface::class);
        $otpMailService->expects(self::once())->method('perform');

        $handler = new OtpCreateCommandHandler(
            $powChallengeValidationService,
            $fingerprintMatchService,
            $turnstileSdk,
            $otpCreateService,
            $otpMailService,
            self::IS_TURNSTILE_VALIDATION_ENABLED,
        );

        // act
        $handler($command);
    }
    
    #[Test]
    public function testHandleNonSuccessTurnstileChallenge()
    {
        // arrange
        $command = new OtpCreateCommand(
            email: self::EMAIL,
            pow_challenge_uuid: $this->uuidHelper->create(),
            pow_challenge_nonce: self::POW_CHALLENGE_NONCE,
            fingerprint: self::FINGERPRINT_VALUE,
            turnstile_token: self::TURNSTILE_TOKEN,
        );

        $powChallengeValidationService = $this->createMock(PowChallengeValidationServiceInterface::class);
        $powChallengeValidationService->expects(self::once())->method('perform');

        $fingerprint = $this->createStub(Fingerprint::class);
        $fingerprint->method('getExpiresAt')->willReturn(null);

        $fingerprintMatchService = $this->createMock(FingerprintMatchServiceInterface::class);

        $fingerprintMatchService
            ->expects(self::once())
            ->method('perform')
            ->with($command->fingerprint)
            ->willReturn($fingerprint)
        ;

        $turnstileResultDto = new TurnstileResultDto(
            success: false,
            challenge_ts: new DateTimeImmutable(),
            hostname: self::HOST,
        );

        $turnstileSdk = $this->createMock(TurnstileSdkInterface::class);
        $turnstileSdk
            ->expects(self::once())
            ->method('getResult')
            ->with($command->turnstile_token)
            ->willReturn($turnstileResultDto)
        ;

        $this->expectException(InvalidArgumentException::class);

        $handler = new OtpCreateCommandHandler(
            $powChallengeValidationService,
            $fingerprintMatchService,
            $turnstileSdk,
            $this->createStub(OtpCreateServiceInterface::class),
            $this->createStub(OtpMailServiceInterface::class),
            self::IS_TURNSTILE_VALIDATION_ENABLED,
        );

        // act
        $handler($command);
    }
}
