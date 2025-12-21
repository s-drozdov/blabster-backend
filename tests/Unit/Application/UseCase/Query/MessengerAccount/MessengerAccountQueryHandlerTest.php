<?php

declare(strict_types=1);

namespace Blabster\Tests\Unit\Application\UseCase\Query\MessengerAccount;

use PHPUnit\Framework\TestCase;
use Blabster\Domain\Entity\User\User;
use PHPUnit\Framework\Attributes\Test;
use Blabster\Domain\Entity\User\MessengerAccount;
use Blabster\Domain\Service\User\GetByEmail\UserByEmailGetServiceInterface;
use Blabster\Application\UseCase\Query\MessengerAccount\MessengerAccountQuery;
use Blabster\Application\UseCase\Query\MessengerAccount\MessengerAccountQueryResult;
use Blabster\Application\UseCase\Query\MessengerAccount\MessengerAccountQueryHandler;

final class MessengerAccountQueryHandlerTest extends TestCase
{
    private const string EMAIL = 'test@test.com';
    private const string LOGIN = 'login';
    private const string PASSWORD = 'password';
    private const string HOST = 'example.com';

    #[Test]
    public function testInvokeSuccess(): void
    {
        // arrange
        $query = new MessengerAccountQuery(
            email: self::EMAIL,
        );

        $messengerAccount = $this->createStub(MessengerAccount::class);
        $messengerAccount->method('getLogin')->willReturn(self::LOGIN);
        $messengerAccount->method('getPassword')->willReturn(self::PASSWORD);
        $messengerAccount->method('getHost')->willReturn(self::HOST);

        $user = $this->createStub(User::class);
        $user->method('getMessengerAccount')->willReturn($messengerAccount);

        $userByEmailGetService = $this->createMock(UserByEmailGetServiceInterface::class);

        $userByEmailGetService
            ->expects(self::once())
            ->method('perform')
            ->with($query->email)
            ->willReturn($user)
        ;

        $handler = new MessengerAccountQueryHandler($userByEmailGetService);

        // act
        $result = $handler($query);

        // assert
        self::assertInstanceOf(MessengerAccountQueryResult::class, $result);
        self::assertSame(self::LOGIN, $result->login);
        self::assertSame(self::PASSWORD, $result->password);
        self::assertSame(self::HOST, $result->host);
    }
}
