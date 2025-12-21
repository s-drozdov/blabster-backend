<?php

declare(strict_types=1);

namespace Blabster\Tests\Unit\Domain\Service\User\Create;

use PHPUnit\Framework\TestCase;
use Blabster\Domain\Entity\User\User;
use PHPUnit\Framework\Attributes\Test;
use Blabster\Domain\Factory\User\UserFactoryInterface;
use Blabster\Domain\Repository\UserRepositoryInterface;
use Blabster\Domain\Service\User\Create\UserCreateService;

final class UserCreateServiceTest extends TestCase
{
    private const string EMAIL = 'test@test.com';

    #[Test]
    public function testPerformCreatesAndSavesUser(): void
    {
        // arrange
        $user = $this->createStub(User::class);

        $userFactory = $this->createMock(UserFactoryInterface::class);

        $userFactory
            ->expects(self::once())
            ->method('create')
            ->with(self::EMAIL)
            ->willReturn($user)
        ;

        $userRepository = $this->createMock(UserRepositoryInterface::class);
        
        $userRepository
            ->expects(self::once())
            ->method('save')
            ->with($user)
        ;

        $service = new UserCreateService($userRepository, $userFactory);

        // act
        $result = $service->perform(self::EMAIL);

        // assert
        self::assertSame($user, $result);
    }
}
