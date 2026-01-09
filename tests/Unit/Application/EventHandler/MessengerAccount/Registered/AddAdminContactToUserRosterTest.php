<?php

declare(strict_types=1);

namespace Blabster\Tests\Unit\Application\EventHandler\MessengerAccount\Registered;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Blabster\Library\SDK\Ejabberd\EjabberdSdkInterface;
use Blabster\Domain\Event\User\MessengerAccountRegistered;
use Blabster\Library\SDK\Ejabberd\Enum\RosterSubscriptionStatus;
use Blabster\Library\SDK\Ejabberd\Request\AddRosterItemRequestDto;
use Blabster\Application\EventHandler\MessengerAccount\Registered\AddAdminContactToUserRoster;

final class AddAdminContactToUserRosterTest extends TestCase
{
    private const string LOGIN = 'login';
    private const string HOST = 'host';
    private const string ADMIN_CONTACT_LOGIN = 'test';
    private const string ADMIN_CONTACT_NICKNAME = 'test_nick';

    #[Test]
    public function testAddsadminContactToRoster(): void
    {
        // arrange
        $event = new MessengerAccountRegistered(
            login: self::LOGIN,
            host: self::HOST,
        );

        $sdk = $this->createMock(EjabberdSdkInterface::class);
        
        $sdk
            ->expects(self::once())
            ->method('addRosterItem')
            ->with(
                self::callback(
                    static function (AddRosterItemRequestDto $dto): bool {
                        return
                            $dto->localuser === self::LOGIN &&
                            $dto->localhost === self::HOST &&
                            $dto->user === self::ADMIN_CONTACT_LOGIN &&
                            $dto->host === self::HOST &&
                            $dto->nick === self::ADMIN_CONTACT_NICKNAME &&
                            $dto->groups === [] &&
                            $dto->subs === RosterSubscriptionStatus::EveryoneSee->value;
                    }
                )
            )
        ;

        $handler = new AddAdminContactToUserRoster(
            ejabberdSdk: $sdk,
            messengerHost: self::HOST,
            adminContactLogin: self::ADMIN_CONTACT_LOGIN,
            adminContactNickname: self::ADMIN_CONTACT_NICKNAME,
        );

        // act
        $handler($event);
    }
}
