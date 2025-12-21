<?php

declare(strict_types=1);

namespace Blabster\Tests\Unit\Domain\Service\MessengerAccount\Create;

use PHPUnit\Framework\TestCase;
use Blabster\Domain\Entity\User\User;
use PHPUnit\Framework\Attributes\Test;
use Blabster\Domain\Entity\User\MessengerAccount;
use Blabster\Domain\Repository\UserRepositoryInterface;
use Blabster\Domain\Factory\User\MessengerAcccountFactoryInterface;
use Blabster\Domain\Service\MessengerAccount\Create\MessengerAccountCreateService;

final class MessengerAccountCreateServiceTest extends TestCase
{
    private const string LOGIN = 'login';
    private const string PASSWORD = 'password';
    private const string HOST = 'example.com';

    #[Test]
    public function testCreatesMessengerAccountAndUpdatesUser(): void
    {
        // arrange
        $user = $this->createMock(User::class);
        $messengerAccount = $this->createStub(MessengerAccount::class);

        $factory = $this->createMock(MessengerAcccountFactoryInterface::class);

        $factory
            ->expects(self::once())
            ->method('create')
            ->with($user, self::LOGIN, self::PASSWORD, self::HOST)
            ->willReturn($messengerAccount)
        ;

        $user->expects(self::once())->method('setMessengerAccount')->with($messengerAccount);

        $repository = $this->createMock(UserRepositoryInterface::class);
        $repository->expects(self::once())->method('update')->with($user);

        $service = new MessengerAccountCreateService(
            $repository,
            $factory,
        );

        // act
        $service->perform($user, self::LOGIN, self::PASSWORD, self::HOST);
    }
}
