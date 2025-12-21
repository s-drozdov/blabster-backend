<?php

declare(strict_types=1);

namespace Blabster\Tests\Unit\Domain\Service\Otp\Create;

use Blabster\Domain\Entity\Otp;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Blabster\Domain\Factory\OtpFactoryInterface;
use Blabster\Domain\Repository\OtpRepositoryInterface;
use Blabster\Domain\Service\Otp\Create\OtpCreateService;

final class OtpCreateServiceTest extends TestCase
{
    private const string EMAIL = 'test@test.com';

    #[Test]
    public function testPerformCreatesAndSavesOtp(): void
    {
        // arrange
        $otp = $this->createStub(Otp::class);

        $otpFactory = $this->createMock(OtpFactoryInterface::class);

        $otpFactory
            ->expects(self::once())
            ->method('create')
            ->with(self::EMAIL)
            ->willReturn($otp)
        ;

        $otpRepository = $this->createMock(OtpRepositoryInterface::class);
        $otpRepository->expects(self::once())->method('save')->with($otp);

        $service = new OtpCreateService($otpFactory, $otpRepository);
        
        // act
        $result = $service->perform(self::EMAIL);

        // assert
        self::assertSame($otp, $result);
    }
}
