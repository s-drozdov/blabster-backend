<?php

declare(strict_types=1);

namespace Blabster\Tests\Unit\Domain\Service\User\GetByEmail;

use PHPUnit\Framework\TestCase;
use Blabster\Domain\Entity\User\User;
use PHPUnit\Framework\Attributes\Test;
use Blabster\Domain\Repository\UserRepositoryInterface;
use Blabster\Domain\Service\User\GetByEmail\UserByEmailGetService;

final class UserByEmailGetServiceTest extends TestCase
{
    private const string EMAIL = 'test@test.com';
    private const string NON_EXISTED_EMAIL = 'test2@test.com';

    #[Test]
    public function testReturnsUserWhenFound(): void
    {
        // arrange
        $user = $this->createStub(User::class);

        $repository = $this->createMock(UserRepositoryInterface::class);

        $repository
            ->expects(self::once())
            ->method('findByEmail')
            ->with(self::EMAIL)
            ->willReturn($user)
        ;

        $service = new UserByEmailGetService($repository);

        // act
        $result = $service->perform(self::EMAIL);

        // assert
        self::assertSame($user, $result);
    }

    public function testReturnsNullWhenUserNotFound(): void
    {
        // arrange
        $repository = $this->createMock(UserRepositoryInterface::class);

        $repository
            ->expects(self::once())
            ->method('findByEmail')
            ->with(self::NON_EXISTED_EMAIL)
            ->willReturn(null)
        ;

        $service = new UserByEmailGetService($repository);

        // act
        $result = $service->perform(self::NON_EXISTED_EMAIL);

        // assert
        self::assertNull($result);
    }
}
