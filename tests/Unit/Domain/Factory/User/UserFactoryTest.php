<?php

declare(strict_types=1);

namespace Blabster\Tests\Unit\Domain\Factory\User;

use DateTimeImmutable;
use InvalidArgumentException;
use Blabster\Domain\Entity\User\User;
use PHPUnit\Framework\Attributes\Test;
use Blabster\Domain\Event\User\UserCreated;
use Blabster\Domain\Factory\User\UserFactory;
use Blabster\Tests\Unit\Domain\Factory\AbstractFactoryTestCase;

final class UserFactoryTest extends AbstractFactoryTestCase
{
    private const string EMAIL = 'test@example.com';

    #[Test]
    public function testCreateUser(): void
    {
        // arrange
        $factory = new UserFactory($this->uuidHelperStub);

        // act
        $user = $factory->create(self::EMAIL);

        // assert
        self::assertInstanceOf(User::class, $user);
        self::assertSame($this->uuid, $user->getUuid());
        self::assertSame(self::EMAIL, $user->getEmail());
        self::assertLessThanOrEqual(new DateTimeImmutable(), $user->getCreatedAt());

        $eventList = $user->pullEvents();
        self::assertCount(1, $eventList);

        $event = current($eventList);
        self::assertInstanceOf(UserCreated::class, $event);
        self::assertSame($this->uuid, $event->uuid);
    }

    #[Test]
    public function testCreateUserWithEmptyEmailThrows(): void
    {
        // arrange
        $factory = new UserFactory($this->uuidHelperStub);

        $this->expectException(InvalidArgumentException::class);

        // act
        $factory->create('');
    }
}
