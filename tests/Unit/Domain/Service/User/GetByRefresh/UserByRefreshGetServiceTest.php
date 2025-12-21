<?php

declare(strict_types=1);

namespace Blabster\Tests\Unit\Domain\Service\User\GetByRefresh;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Blabster\Domain\Entity\User\User;
use PHPUnit\Framework\Attributes\Test;
use Blabster\Domain\Repository\UserRepositoryInterface;
use Blabster\Domain\Service\User\GetByRefresh\UserByRefreshGetService;

final class UserByRefreshGetServiceTest extends TestCase
{
    private const string EMAIL = 'test@test.com';
    private const string REFRESH_TOKEN_VALUE = 'refresh-token-value';
    private const string INVALID_REFRESH_TOKEN_VALUE = 'invalid-refresh-token-value';

    #[Test]
    public function testReturnsUserByEmailAndRefreshToken(): void
    {
        // arrange
        $user = $this->createStub(User::class);

        $repository = $this->createMock(UserRepositoryInterface::class);

        $repository
            ->expects(self::once())
            ->method('getByEmailAndToken')
            ->with(self::EMAIL, self::REFRESH_TOKEN_VALUE)
            ->willReturn($user)
        ;

        $service = new UserByRefreshGetService($repository);

        // act
        $result = $service->perform(self::EMAIL, self::REFRESH_TOKEN_VALUE);

        // assert
        self::assertSame($user, $result);
    }

    #[Test]
    public function testExceptionFromRepositoryIsNotCaught(): void
    {
        // arrange
        $repository = $this->createMock(UserRepositoryInterface::class);

        $repository
            ->expects(self::once())
            ->method('getByEmailAndToken')
            ->with(self::EMAIL, self::INVALID_REFRESH_TOKEN_VALUE)
            ->willThrowException(new InvalidArgumentException())
        ;

        $service = new UserByRefreshGetService($repository);

        $this->expectException(InvalidArgumentException::class);

        // act
        $service->perform(self::EMAIL, self::INVALID_REFRESH_TOKEN_VALUE);
    }
}
