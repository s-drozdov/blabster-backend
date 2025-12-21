<?php

declare(strict_types=1);

namespace Blabster\Tests\Unit\Domain\Factory\User;

use DateTimeImmutable;
use Blabster\Domain\Entity\User\User;
use PHPUnit\Framework\Attributes\Test;
use Blabster\Domain\Entity\User\MessengerAccount;
use Blabster\Domain\Event\User\MessengerAccountRegistered;
use Blabster\Domain\Factory\User\MessengerAcccountFactory;
use Blabster\Tests\Unit\Domain\Factory\AbstractFactoryTestCase;

final class MessengerAccountFactoryTest extends AbstractFactoryTestCase
{
    private const string EMAIL = 'test@test.com';
    private const string LOGIN = 'test';
    private const string PASSWORD = 'p455w0rD';
    private const string HOST = 'example.com';

    #[Test]
    public function testCreateMessengerAccount(): void
    {
        // arrange
        $factory = new MessengerAcccountFactory($this->uuidHelperStub);

        $user = new User(
            uuid: $this->uuidHelper->create(),
            email: self::EMAIL,
            created_at: new DateTimeImmutable(),
        );

        // act
        $messengerAccount = $factory->create($user, self::LOGIN, self::PASSWORD, self::HOST);

        // assert
        self::assertInstanceOf(MessengerAccount::class, $messengerAccount);
        self::assertSame($this->uuid, $messengerAccount->getUuid());
        self::assertSame($user, $messengerAccount->getUser());
        self::assertSame(self::LOGIN, $messengerAccount->getLogin());
        self::assertSame(self::PASSWORD, $messengerAccount->getPassword());
        self::assertSame(self::HOST, $messengerAccount->getHost());

        $eventList = $user->pullEvents();
        self::assertCount(1, $eventList);

        $event = current($eventList);

        self::assertInstanceOf(MessengerAccountRegistered::class, $event);
        self::assertSame(self::LOGIN, $event->login);
        self::assertSame(self::HOST, $event->host);
    }
}
