<?php

declare(strict_types=1);

namespace Blabster\Tests\Unit\Domain\Service\User\Logout;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Blabster\Domain\Entity\User\User;
use PHPUnit\Framework\Attributes\Test;
use Blabster\Domain\Entity\User\RefreshToken;
use Doctrine\Common\Collections\ArrayCollection;
use Blabster\Domain\Repository\UserRepositoryInterface;
use Blabster\Domain\Service\User\Logout\UserLogoutService;
use Blabster\Domain\Repository\RefreshTokenRepositoryInterface;

final class UserLogoutServiceTest extends TestCase
{
    private const string EMAIL = 'test@test.com';
    private const string REFRESH_TOKEN_VALUE = 'refresh-token-value';
    private const string NON_EXISTED_REFRESH_TOKEN_VALUE = 'non-existed-refresh-token-value';

    #[Test]
    public function testLogoutRemovesRefreshTokenAndUpdatesUser(): void
    {
        // arrange
        $token = $this->createStub(RefreshToken::class);
        $tokenList = new ArrayCollection([$token]);

        $user = $this->createStub(User::class);
        $user->method('getRefreshTokenList')->willReturn($tokenList);

        $userRepository = $this->createMock(UserRepositoryInterface::class);

        $userRepository
            ->expects(self::once())
            ->method('getByEmailAndToken')
            ->with(self::EMAIL, self::REFRESH_TOKEN_VALUE)
            ->willReturn($user)
        ;

        $userRepository->expects(self::once())->method('update')->with($user);

        $refreshTokenRepository = $this->createMock(RefreshTokenRepositoryInterface::class);
        
        $refreshTokenRepository
            ->expects(self::once())
            ->method('findByToken')
            ->with(self::REFRESH_TOKEN_VALUE)
            ->willReturn($token)
        ;

        $service = new UserLogoutService(
            $userRepository,
            $refreshTokenRepository,
        );

        // act
        $result = $service->perform(self::EMAIL, self::REFRESH_TOKEN_VALUE);

        // assert
        self::assertSame($user, $result);
        self::assertCount(0, $tokenList);
    }

    #[Test]
    public function testLogoutThrowsWhenRefreshTokenNotFound(): void
    {
        // arrange
        $user = $this->createStub(User::class);

        $userRepository = $this->createStub(UserRepositoryInterface::class);
        $userRepository->method('getByEmailAndToken')->willReturn($user);

        $refreshTokenRepository = $this->createStub(RefreshTokenRepositoryInterface::class);
        $refreshTokenRepository->method('findByToken')->willReturn(null);

        $service = new UserLogoutService(
            $userRepository,
            $refreshTokenRepository,
        );

        $this->expectException(InvalidArgumentException::class);

        // act
        $service->perform(self::EMAIL, self::NON_EXISTED_REFRESH_TOKEN_VALUE);
    }
}
