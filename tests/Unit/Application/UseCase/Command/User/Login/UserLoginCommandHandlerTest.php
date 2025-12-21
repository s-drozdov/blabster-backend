<?php

declare(strict_types=1);

namespace Blabster\Tests\Unit\Application\UseCase\Command\User\Login;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Blabster\Domain\Entity\User\User;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\Before;
use Blabster\Domain\Entity\User\RefreshToken;
use Blabster\Domain\Helper\Uuid\UuidHelperInterface;
use Blabster\Application\Bus\Event\EventBusInterface;
use Blabster\Infrastructure\Helper\Uuid\RamseyUuidHelper;
use Blabster\Library\DbTransaction\DbTransactionInterface;
use Blabster\Domain\Service\Otp\Verify\OtpVerifyServiceInterface;
use Blabster\Domain\Service\User\Create\UserCreateServiceInterface;
use Blabster\Application\UseCase\Command\User\Login\UserLoginCommand;
use Blabster\Application\UseCase\Command\User\Login\UserLoginCommandResult;
use Blabster\Domain\Service\User\GetByEmail\UserByEmailGetServiceInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Blabster\Application\UseCase\Command\User\Login\UserLoginCommandHandler;
use Blabster\Domain\Service\RefreshToken\Create\RefreshTokenCreateServiceInterface;

final class UserLoginCommandHandlerTest extends TestCase
{
    private const string EMAIL = 'test@test.com';
    private const string UUID_STRING = '123e4567-e89b-12d3-a456-426614174000';
    private const string OTP_CODE = '123456';
    private const string REFRESH_TOKEN_VALUE  = 'refresh-token';
    private const string ACCESS_TOKEN_VALUE  = 'access-token';

    private UuidHelperInterface $uuidHelper;
    
    #[Before]
    public function before(): void
    {
        $this->uuidHelper = new RamseyUuidHelper();
    }

    #[Test]
    public function testHandle(): void
    {
        // arrange
        $command = new UserLoginCommand(
            email: self::EMAIL,
            otp_uuid: $this->uuidHelper->fromString(self::UUID_STRING),
            otp_code: self::OTP_CODE,
        );

        $user = $this->createStub(User::class);
        $user->method('pullEvents')->willReturn([]);

        $refreshToken = $this->createStub(RefreshToken::class);
        $refreshToken->method('getValue')->willReturn(self::REFRESH_TOKEN_VALUE);
        $refreshToken->method('getExpiresAt')->willReturn(new \DateTimeImmutable('+1 day'));

        $otpVerifyService = $this->createMock(OtpVerifyServiceInterface::class);

        $otpVerifyService
            ->expects(self::once())
            ->method('perform')
            ->with($command->email, $command->otp_uuid, $command->otp_code)
        ;

        $userByEmailGetService = $this->createMock(UserByEmailGetServiceInterface::class);

        $userByEmailGetService
            ->expects(self::once())
            ->method('perform')
            ->with($command->email)
            ->willReturn($user)
        ;

        $userCreateService = $this->createMock(UserCreateServiceInterface::class);

        $userCreateService
            ->expects(self::never())
            ->method('perform')
        ;

        $eventBus = $this->createMock(EventBusInterface::class);
        $eventBus->expects(self::once())->method('dispatch');

        $refreshTokenCreateService = $this->createMock(RefreshTokenCreateServiceInterface::class);
        
        $refreshTokenCreateService
            ->expects(self::once())
            ->method('perform')
            ->with($user)
            ->willReturn($refreshToken)
        ;

        $jwtManager = $this->createMock(JWTTokenManagerInterface::class);

        $jwtManager
            ->expects(self::once())
            ->method('create')
            ->with($user)
            ->willReturn(self::ACCESS_TOKEN_VALUE)
        ;

        $dbTransaction = $this->createMock(DbTransactionInterface::class);
        $dbTransaction
            ->expects(self::once())
            ->method('execute')
            ->willReturnCallback(
                static fn (callable $callback) => $callback(),
            )
        ;

        $handler = new UserLoginCommandHandler(
            $otpVerifyService,
            $jwtManager,
            $refreshTokenCreateService,
            $userByEmailGetService,
            $userCreateService,
            $eventBus,
            $dbTransaction,
        );

        // act
        $result = $handler($command);

        // assert
        self::assertInstanceOf(UserLoginCommandResult::class, $result);
        self::assertSame(self::ACCESS_TOKEN_VALUE, $result->access_token);
        self::assertSame(self::REFRESH_TOKEN_VALUE, $result->refresh_token_value);
        self::assertInstanceOf(DateTimeImmutable::class, $result->refresh_token_expires_at);
    }
}
