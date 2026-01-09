<?php

declare(strict_types=1);

namespace Blabster\Tests\Unit\Application\EventHandler\MessengerAccount\Registered;

use PHPUnit\Framework\Test;
use PHPUnit\Framework\TestCase;
use Blabster\Library\SDK\Ejabberd\EjabberdSdkInterface;
use Blabster\Domain\Event\User\MessengerAccountRegistered;
use Blabster\Library\SDK\Ejabberd\Enum\RosterSubscriptionStatus;
use Blabster\Library\SDK\Ejabberd\Request\AddRosterItemRequestDto;
use Blabster\Application\EventHandler\MessengerAccount\Registered\AddUserContactToAdminRoster;

final class AddUserContactToAdminRosterTest extends TestCase
{
    private const string LOGIN = 'login';
    private const string HOST = 'host';
    private const string ADMIN_CONTACT_LOGIN = 'test';
    private const string ADMIN_CONTACT_GROUP = 'test_group';

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
                            $dto->localuser === self::ADMIN_CONTACT_LOGIN &&
                            $dto->localhost === self::HOST &&


                            $dto->user === self::LOGIN &&
                            $dto->host === self::HOST &&
                            $dto->nick === self::LOGIN &&
                            $dto->groups === [self::ADMIN_CONTACT_GROUP] &&
                            $dto->subs === RosterSubscriptionStatus::EveryoneSee->value;
                    }
                )
            )
        ;

        $handler = new AddUserContactToAdminRoster(
            ejabberdSdk: $sdk,
            messengerHost: self::HOST,
            adminContactLogin: self::ADMIN_CONTACT_LOGIN,
            adminContactGroup: self::ADMIN_CONTACT_GROUP,
        );

        // act
        $handler($event);
    }
}
