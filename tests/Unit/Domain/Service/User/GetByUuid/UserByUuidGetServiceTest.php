<?php

declare(strict_types=1);

namespace Blabster\Tests\Unit\Domain\Service\User\GetByUuid;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Blabster\Domain\Entity\User\User;
use PHPUnit\Framework\Attributes\Test;
use Blabster\Domain\ValueObject\UuidInterface;
use Blabster\Domain\Repository\UserRepositoryInterface;
use Blabster\Domain\Service\User\GetByUuid\UserByUuidGetService;


final class UserByUuidGetServiceTest extends TestCase
{
    #[Test]
    public function testReturnsUserByUuid(): void
    {
        // arrange
        $uuid = $this->createStub(UuidInterface::class);
        $user = $this->createStub(User::class);

        $repository = $this->createMock(UserRepositoryInterface::class);
        $repository->expects(self::once())
            ->method('getByUuid')
            ->with($uuid)
            ->willReturn($user);

        $service = new UserByUuidGetService($repository);

        // act
        $result = $service->perform($uuid);

        // assert
        self::assertSame($user, $result);
    }

    #[Test]
    public function testExceptionFromRepositoryIsNotCaught(): void
    {
        // arrange
        $uuid = $this->createStub(UuidInterface::class);

        $repository = $this->createMock(UserRepositoryInterface::class);

        $repository
            ->expects(self::once())
            ->method('getByUuid')
            ->with($uuid)
            ->willThrowException(new InvalidArgumentException())
        ;

        $service = new UserByUuidGetService($repository);

        $this->expectException(InvalidArgumentException::class);

        // act
        $service->perform($uuid);
    }
}
