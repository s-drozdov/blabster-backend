<?php

declare(strict_types=1);

namespace Blabster\Tests\Unit\Domain\Service\Otp\Verify;

use InvalidArgumentException;
use Blabster\Domain\Entity\Otp;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Blabster\Domain\ValueObject\UuidInterface;
use Blabster\Domain\Repository\OtpRepositoryInterface;
use Blabster\Domain\Service\Otp\Verify\OtpVerifyService;

final class OtpVerifyServiceTest extends TestCase
{
    private const string EMAIL = 'test@test.com';
    private const string ANOTHER_EMAIL = 'test1@test.com';
    private const string CODE = '123456';
    private const string ANOTHER_CODE = '98765';

    #[Test]
    public function testVerifySuccess(): void
    {
        // arrange
        $otpUuid = $this->createStub(UuidInterface::class);

        $otp = $this->createStub(Otp::class);
        $otp->method('getEmail')->willReturn(self::EMAIL);
        $otp->method('getCode')->willReturn(self::CODE);

        $repository = $this->createMock(OtpRepositoryInterface::class);

        $repository
            ->expects(self::once())
            ->method('getByUuid')
            ->with($otpUuid)
            ->willReturn($otp)
        ;

        $service = new OtpVerifyService($repository);

        // act
        $service->perform(self::EMAIL, $otpUuid, self::CODE);
        
        // assert
        self::assertTrue(true);
    }

    #[Test]
    public function testVerifyThrowsWhenEmailMismatch(): void
    {
        // arrange
        $otpUuid = $this->createStub(UuidInterface::class);

        $otp = $this->createStub(Otp::class);
        $otp->method('getEmail')->willReturn(self::EMAIL);
        $otp->method('getCode')->willReturn(self::CODE);

        $repository = $this->createStub(OtpRepositoryInterface::class);
        $repository->method('getByUuid')->willReturn($otp);

        $service = new OtpVerifyService($repository);

        $this->expectException(InvalidArgumentException::class);

        // act
        $service->perform(self::ANOTHER_EMAIL, $otpUuid, self::CODE);
    }

    #[Test]
    public function testVerifyThrowsWhenCodeMismatch(): void
    {
        // arrange
        $otpUuid = $this->createStub(UuidInterface::class);

        $otp = $this->createStub(Otp::class);
        $otp->method('getEmail')->willReturn(self::EMAIL);
        $otp->method('getCode')->willReturn(self::CODE);

        $repository = $this->createStub(OtpRepositoryInterface::class);
        $repository->method('getByUuid')->willReturn($otp);

        $service = new OtpVerifyService($repository);

        $this->expectException(InvalidArgumentException::class);

        // act
        $service->perform(self::EMAIL, $otpUuid, self::ANOTHER_CODE);
    }
}
