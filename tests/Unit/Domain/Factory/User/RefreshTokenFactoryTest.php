<?php

declare(strict_types=1);

namespace Blabster\Tests\Unit\Domain\Factory\User;

use DateInterval;
use DateTimeImmutable;
use InvalidArgumentException;
use Blabster\Domain\Entity\User\User;
use PHPUnit\Framework\Attributes\Test;
use Blabster\Domain\Entity\User\RefreshToken;
use Blabster\Domain\Helper\Uuid\UuidHelperInterface;
use Blabster\Domain\Factory\User\RefreshTokenFactory;
use Blabster\Tests\Unit\Domain\Factory\AbstractFactoryTestCase;

final class RefreshTokenFactoryTest extends AbstractFactoryTestCase
{
    private const string EXPIRATION_PERIOD = 'PT1H';
    private const string TOKEN_VALUE = 'test-token';

    #[Test]
    public function testCreateRefreshToken(): void
    {
        // arrange
        $now = new DateTimeImmutable();
        $factory = new RefreshTokenFactory($this->uuidHelperStub, self::EXPIRATION_PERIOD);
        $expected = $now->add(new DateInterval(self::EXPIRATION_PERIOD));

        $user = $this->createStub(User::class);

        // act
        $refreshToken = $factory->create($user, self::TOKEN_VALUE);

        // assert
        self::assertInstanceOf(RefreshToken::class, $refreshToken);
        self::assertSame($this->uuid, $refreshToken->getUuid());
        self::assertSame($user, $refreshToken->getUser());
        self::assertSame(self::TOKEN_VALUE, $refreshToken->getValue());

        self::assertGreaterThanOrEqual($now, $refreshToken->getExpiresAt());

        $diff = $refreshToken->getExpiresAt()->getTimestamp() - $expected->getTimestamp();
        self::assertLessThanOrEqual(1, abs($diff));
    }

    #[Test]
    public function testCreateRefreshTokenWithEmptyValueThrows(): void
    {
        // arrange
        $uuidHelper = $this->createStub(UuidHelperInterface::class);
        $factory = new RefreshTokenFactory($uuidHelper, self::EXPIRATION_PERIOD);

        $user = $this->createStub(User::class);

        $this->expectException(InvalidArgumentException::class);

        // act
        $factory->create($user, '');
    }
}
