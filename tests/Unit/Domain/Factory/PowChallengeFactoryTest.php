<?php

declare(strict_types=1);

namespace Blabster\Tests\Unit\Domain\Factory;

use Blabster\Domain\Entity\PowChallenge;
use DateTimeImmutable;
use PHPUnit\Framework\Attributes\Test;
use Blabster\Domain\Factory\PowChallengeFactory;
use Blabster\Domain\Helper\DateTime\DateTimeHelperInterface;

final class PowChallengeFactoryTest extends AbstractFactoryTestCase
{
    private const int TTL_SECONDS = 3600;
    private const int DIFFICULTY = 8;

    #[Test]
    public function testCreatePowChallenge(): void
    {
        // arrange
        $expiresAt = new DateTimeImmutable('+1 hour');

        $dateTimeHelper = $this->createStub(DateTimeHelperInterface::class);
        $dateTimeHelper->method('getExpiresAt')->willReturn($expiresAt);

        $factory = new PowChallengeFactory($this->uuidHelperStub, $dateTimeHelper, self::TTL_SECONDS);
        
        // act
        $powChallenge = $factory->create(self::DIFFICULTY);

        // assert
        self::assertInstanceOf(PowChallenge::class, $powChallenge);
        self::assertSame($this->uuid, $powChallenge->getUuid());
        self::assertSame(self::DIFFICULTY, $powChallenge->getDifficulty());
        self::assertSame($expiresAt, $powChallenge->getExpiresAt());

        self::assertMatchesRegularExpression('/^[0-9a-f]{32}$/', $powChallenge->getPrefix());
        self::assertMatchesRegularExpression('/^[0-9a-f]{32}$/', $powChallenge->getSalt());
    }
}
