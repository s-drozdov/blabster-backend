<?php

declare(strict_types=1);

namespace Blabster\Tests\Unit\Domain\Service\RefreshToken\Create;

use PHPUnit\Framework\TestCase;
use Blabster\Domain\Entity\User\User;
use PHPUnit\Framework\Attributes\Test;
use Blabster\Domain\Entity\User\RefreshToken;
use Blabster\Domain\Factory\User\RefreshTokenFactoryInterface;
use Blabster\Domain\Repository\RefreshTokenRepositoryInterface;
use Blabster\Domain\Service\RefreshToken\Create\RefreshTokenCreateService;

final class RefreshTokenCreateServiceTest extends TestCase
{
    #[Test]
    public function testPerformCreatesAndSavesRefreshToken(): void
    {
        // arrange
        $user = $this->createStub(User::class);
        $refreshToken = $this->createStub(RefreshToken::class);

        $factory = $this->createMock(RefreshTokenFactoryInterface::class);

        $factory
            ->expects(self::once())
            ->method('create')
            ->with(
                $user,
                self::callback(
                    static fn (string $token): bool =>
                        $token !== '' && ctype_xdigit($token)
                ),
            )
            ->willReturn($refreshToken)
        ;

        $repository = $this->createMock(RefreshTokenRepositoryInterface::class);
        $repository->expects(self::once())->method('save')->with($refreshToken);

        $service = new RefreshTokenCreateService($repository, $factory);

        // act
        $result = $service->perform($user);

        // assert
        self::assertSame($refreshToken, $result);
    }
}
