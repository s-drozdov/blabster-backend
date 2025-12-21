<?php

declare(strict_types=1);

namespace Blabster\Tests\Unit\Application\UseCase\Command\User\LogoutAll;

use PHPUnit\Framework\Test;
use PHPUnit\Framework\TestCase;
use Blabster\Domain\Entity\User\User;
use Blabster\Application\Bus\Event\EventBusInterface;
use Blabster\Domain\Service\User\LogoutAll\UserLogoutAllServiceInterface;
use Blabster\Application\UseCase\Command\User\LogoutAll\UserLogoutAllCommand;
use Blabster\Application\UseCase\Command\User\LogoutAll\UserLogoutAllCommandResult;
use Blabster\Application\UseCase\Command\User\LogoutAll\UserLogoutAllCommandHandler;

final class UserLogoutAllCommandHandlerTest extends TestCase
{
    private const string EMAIL = 'test@test.com';
    private const string REFRESH_TOKEN_VALUE = 'refresh-token';

    #[Test]
    public function testHandle(): void
    {
        // arrange
        $command = new UserLogoutAllCommand(
            email: self::EMAIL,
            refresh_token_value: self::REFRESH_TOKEN_VALUE,
        );

        $user = $this->createStub(User::class);
        $user->method('pullEvents')->willReturn([]);

        $userLogoutAllService = $this->createMock(UserLogoutAllServiceInterface::class);
        
        $userLogoutAllService
            ->expects(self::once())
            ->method('perform')
            ->with($command->email, $command->refresh_token_value)
            ->willReturn($user)
        ;

        $eventBus = $this->createMock(EventBusInterface::class);
        $eventBus
            ->expects(self::once())
            ->method('dispatch')
        ;

        $handler = new UserLogoutAllCommandHandler(
            $userLogoutAllService,
            $eventBus,
        );

        // act
        $result = $handler($command);

        // assert
        self::assertInstanceOf(UserLogoutAllCommandResult::class, $result);
    }
}
