<?php

declare(strict_types=1);

namespace Blabster\Tests\Unit\Application\EventHandler\User\Created;

use PHPUnit\Framework\TestCase;
use Blabster\Domain\Entity\User\User;
use PHPUnit\Framework\Attributes\Test;
use Blabster\Domain\Event\User\UserCreated;
use Blabster\Domain\ValueObject\UuidInterface;
use Blabster\Domain\Helper\Uuid\UuidHelperInterface;
use Blabster\Application\Bus\Event\EventBusInterface;
use Blabster\Library\SDK\Ejabberd\EjabberdSdkInterface;
use Blabster\Domain\Helper\String\StringHelperInterface;
use Blabster\Library\SDK\Ejabberd\Response\CheckAccountResponseDto;
use Blabster\Domain\Service\User\GetByUuid\UserByUuidGetServiceInterface;
use Blabster\Application\EventHandler\User\Created\RegisterMessengerAccount;
use Blabster\Domain\Service\MessengerAccount\Create\MessengerAccountCreateServiceInterface;

final class RegisterMessengerAccountTest extends TestCase
{
    private const string EMAIL = 'test.test@test.com';
    private const string LOGIN = 'test.test';
    private const string PASSWORD = 'abcd1234()';
    private const string HOST = 'host';

    #[Test]
    public function testRegistersMessengerAccountForNewUser(): void
    {
        // arrange
        $uuid = $this->createStub(UuidInterface::class);

        $event = new UserCreated(uuid: $uuid);

        $user = $this->createStub(User::class);
        $user->method('getEmail')->willReturn(self::EMAIL);
        $user->method('pullEvents')->willReturn([]);

        $userByUuidGetService = $this->createMock(UserByUuidGetServiceInterface::class);
        $userByUuidGetService->expects(self::once())->method('perform')->with($uuid)->willReturn($user);

        $stringHelper = $this->createStub(StringHelperInterface::class);

        $stringHelper->method('getLocalPartFromEmail')->willReturn(self::LOGIN);
        $stringHelper->method('generateMessengerPassword')->willReturn(self::PASSWORD);

        $ejabberdSdk = $this->createMock(EjabberdSdkInterface::class);

        $ejabberdSdk->method('checkAccount')->willReturn(
            new CheckAccountResponseDto(is_user_exist: false),
        );

        $ejabberdSdk->expects(self::once())->method('register');

        $messengerAccountCreateService = $this->createMock(MessengerAccountCreateServiceInterface::class);

        $messengerAccountCreateService
            ->expects(self::once())
            ->method('perform')
            ->with($user, self::LOGIN, self::PASSWORD, self::HOST)
        ;

        $eventBus = $this->createMock(EventBusInterface::class);
        $eventBus->expects(self::once())->method('dispatch');

        $handler = new RegisterMessengerAccount(
            userByUuidGetService: $userByUuidGetService,
            ejabberdSdk: $ejabberdSdk,
            stringHelper: $stringHelper,
            uuidHelper: $this->createStub(UuidHelperInterface::class),
            messengerAccountCreateService: $messengerAccountCreateService,
            eventBus: $eventBus,
            messengerHost: self::HOST,
        );

        // act
        $handler($event);
    }
}
