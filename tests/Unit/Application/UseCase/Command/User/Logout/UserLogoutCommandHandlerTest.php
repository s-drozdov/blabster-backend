<?php

declare(strict_types=1);

namespace Blabster\Tests\Unit\Application\UseCase\Command\User\Logout;

use PHPUnit\Framework\TestCase;
use Blabster\Domain\Entity\User\User;
use PHPUnit\Framework\Attributes\Test;
use Blabster\Application\Bus\Event\EventBusInterface;
use Blabster\Domain\Service\User\Logout\UserLogoutServiceInterface;
use Blabster\Application\UseCase\Command\User\Logout\UserLogoutCommand;
use Blabster\Application\UseCase\Command\User\Logout\UserLogoutCommandResult;
use Blabster\Application\UseCase\Command\User\Logout\UserLogoutCommandHandler;

final class UserLogoutCommandHandlerTest extends TestCase
{
    private const string REFRESH_TOKEN_VALUE = 'refresh-token';

    #[Test]
    public function testHandle(): void
    {
        // arrange
        $command = new UserLogoutCommand(
            refresh_token_value: self::REFRESH_TOKEN_VALUE,
        );

        $user = $this->createStub(User::class);
        $user->method('pullEvents')->willReturn([]);

        $userLogoutService = $this->createMock(UserLogoutServiceInterface::class);

        $userLogoutService
            ->expects(self::once())
            ->method('perform')
            ->with($command->refresh_token_value)
            ->willReturn($user)
        ;

        $eventBus = $this->createMock(EventBusInterface::class);
        $eventBus->expects(self::once())->method('dispatch');

        $handler = new UserLogoutCommandHandler(
            $userLogoutService,
            $eventBus,
        );

        // act
        $result = $handler($command);

        // assert
        self::assertInstanceOf(UserLogoutCommandResult::class, $result);
    }
}
