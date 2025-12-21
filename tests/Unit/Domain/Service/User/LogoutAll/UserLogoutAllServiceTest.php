<?php

declare(strict_types=1);

namespace Blabster\Tests\Unit\Domain\Service\User\LogoutAll;

use PHPUnit\Framework\TestCase;
use Blabster\Domain\Entity\User\User;
use PHPUnit\Framework\Attributes\Test;
use Blabster\Domain\Entity\User\RefreshToken;
use Doctrine\Common\Collections\ArrayCollection;
use Blabster\Domain\Repository\UserRepositoryInterface;
use Blabster\Domain\Service\User\LogoutAll\UserLogoutAllService;

final class UserLogoutAllServiceTest extends TestCase
{
    private const string EMAIL = 'test@test.com';
    private const string REFRESH_TOKEN_VALUE = 'refresh-token-value';

    #[Test]
    public function testLogoutAllClearsAllRefreshTokensAndUpdatesUser(): void
    {
        // arrange
        $tokenList = new ArrayCollection([
            $this->createStub(RefreshToken::class),
            $this->createStub(RefreshToken::class),
        ]);

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

        $service = new UserLogoutAllService($userRepository);

        // act
        $result = $service->perform(self::EMAIL, self::REFRESH_TOKEN_VALUE);

        // assert
        self::assertSame($user, $result);
        self::assertCount(0, $tokenList);
    }
}
