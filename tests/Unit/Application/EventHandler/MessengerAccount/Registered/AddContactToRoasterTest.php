<?php

declare(strict_types=1);

namespace Blabster\Tests\Unit\Application\EventHandler\MessengerAccount\Registered;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Blabster\Library\SDK\Ejabberd\EjabberdSdkInterface;
use Blabster\Domain\Event\User\MessengerAccountRegistered;
use Blabster\Library\SDK\Ejabberd\Enum\RosterSubscriptionStatus;
use Blabster\Library\SDK\Ejabberd\Request\AddRosterItemRequestDto;
use Blabster\Application\EventHandler\MessengerAccount\Registered\AddContactToRoaster;

final class AddContactToRoasterTest extends TestCase
{
    private const string LOGIN = 'login';
    private const string HOST = 'host';
    private const string REQUIRED_CONTACT_LOGIN = 'test';
    private const string REQUIRED_CONTACT_NICKNAME = 'test_nick';

    #[Test]
    public function testAddsRequiredContactToRoster(): void
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
                            $dto->user === self::REQUIRED_CONTACT_LOGIN &&
                            $dto->host === self::HOST &&
                            $dto->nick === self::REQUIRED_CONTACT_NICKNAME &&
                            $dto->groups === [] &&
                            $dto->subs === RosterSubscriptionStatus::EveryoneSee->value;
                    }
                )
            )
        ;

        $handler = new AddContactToRoaster(
            ejabberdSdk: $sdk,
            messengerHost: self::HOST,
            requiredContactLogin: self::REQUIRED_CONTACT_LOGIN,
            requiredContactNickname: self::REQUIRED_CONTACT_NICKNAME,
        );

        // act
        $handler($event);
    }
}
