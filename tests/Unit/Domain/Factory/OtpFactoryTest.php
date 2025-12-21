<?php

declare(strict_types=1);

namespace Blabster\Tests\Unit\Domain\Factory;

use Blabster\Domain\Entity\Otp;
use PHPUnit\Framework\Attributes\Test;
use Blabster\Domain\Factory\OtpFactory;

final class OtpFactoryTest extends AbstractFactoryTestCase
{
    private const string EMAIL = 'test@test.com';

    #[Test]
    public function testCreateOtp(): void
    {
        // arrange
        $factory = new OtpFactory($this->uuidHelperStub);
        
        // act
        $otp = $factory->create(self::EMAIL);

        // assert
        self::assertInstanceOf(Otp::class, $otp);
        self::assertSame($this->uuid, $otp->getUuid());
        self::assertTrue(strlen($otp->getCode()) === 5);
        self::assertSame(self::EMAIL, $otp->getEmail());
    }
}
