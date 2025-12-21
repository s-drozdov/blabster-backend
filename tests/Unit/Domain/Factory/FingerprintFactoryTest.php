<?php

declare(strict_types=1);

namespace Blabster\Tests\Unit\Domain\Factory;

use DateTimeImmutable;
use PHPUnit\Framework\Attributes\Test;
use Blabster\Domain\Entity\Fingerprint;
use Blabster\Domain\Factory\FingerprintFactory;
use Blabster\Domain\Helper\DateTime\DateTimeHelperInterface;

final class FingerprintFactoryTest extends AbstractFactoryTestCase
{
    private const string FINGERPRINT_VALUE = 'test-fingerprint';
    private const int TTL_SECONDS = 3600;

    #[Test]
    public function testCreateFingerprint(): void
    {
        // arrange
        $expiresAt = new DateTimeImmutable('+1 hour');

        $dateTimeHelper = $this->createStub(DateTimeHelperInterface::class);
        $dateTimeHelper->method('getExpiresAt')->willReturn($expiresAt);

        $factory = new FingerprintFactory($this->uuidHelperStub, $dateTimeHelper, self::TTL_SECONDS);
        
        // act
        $fingerprint = $factory->create(self::FINGERPRINT_VALUE);

        // assert
        self::assertInstanceOf(Fingerprint::class, $fingerprint);
        self::assertSame($this->uuid, $fingerprint->getUuid());
        self::assertSame(self::FINGERPRINT_VALUE, $fingerprint->getValue());
        self::assertSame($expiresAt, $fingerprint->getExpiresAt());
    }
}
