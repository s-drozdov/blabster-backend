<?php

declare(strict_types=1);

namespace Blabster\Tests\Unit\Application\UseCase\Command\User\Refresh;

use PHPUnit\Framework\TestCase;
use Blabster\Domain\Entity\User\User;
use PHPUnit\Framework\Attributes\Test;
use Blabster\Application\Bus\Event\EventBusInterface;
use Blabster\Application\UseCase\Command\User\Refresh\UserRefreshCommand;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Blabster\Application\UseCase\Command\User\Refresh\UserRefreshCommandResult;
use Blabster\Domain\Service\User\GetByRefresh\UserByRefreshGetServiceInterface;
use Blabster\Application\UseCase\Command\User\Refresh\UserRefreshCommandHandler;

final class UserRefreshCommandHandlerTest extends TestCase
{
    private const string EMAIL = 'test@test.com';
    private const string ACCESS_TOKEN_VALUE  = 'access-token';
    private const string REFRESH_TOKEN_VALUE = 'refresh-token';

    #[Test]
    public function testHandle(): void
    {
        // arrange
        $command = new UserRefreshCommand(
            email: self::EMAIL,
            refresh_token_value: self::REFRESH_TOKEN_VALUE,
        );

        $user = $this->createStub(User::class);
        $user->method('pullEvents')->willReturn([]);

        $userByRefreshGetService = $this->createMock(UserByRefreshGetServiceInterface::class);

        $userByRefreshGetService
            ->expects(self::once())
            ->method('perform')
            ->with($command->email, $command->refresh_token_value)
            ->willReturn($user)
        ;

        $jwtManager = $this->createMock(JWTTokenManagerInterface::class);

        $jwtManager
            ->expects(self::once())
            ->method('create')
            ->with($user)
            ->willReturn(self::ACCESS_TOKEN_VALUE)
        ;

        $eventBus = $this->createMock(EventBusInterface::class);
        $eventBus->expects(self::once())->method('dispatch');

        $handler = new UserRefreshCommandHandler(
            $userByRefreshGetService,
            $jwtManager,
            $eventBus,
        );

        // act
        $result = $handler($command);

        // assert
        self::assertInstanceOf(UserRefreshCommandResult::class, $result);
        self::assertSame(self::ACCESS_TOKEN_VALUE, $result->access_token);
    }
}
