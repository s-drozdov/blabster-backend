<?php

declare(strict_types=1);

namespace Blabster\Application\UseCase\Command\User\Login;

use Override;
use InvalidArgumentException;
use Blabster\Domain\Entity\User\User;
use Blabster\Application\Bus\CqrsElementInterface;
use Blabster\Application\Bus\Event\EventBusInterface;
use Blabster\Library\DbTransaction\DbTransactionInterface;
use Blabster\Application\Bus\Command\CommandHandlerInterface;
use Blabster\Domain\Service\Otp\Verify\OtpVerifyServiceInterface;
use Blabster\Domain\Service\User\Create\UserCreateServiceInterface;
use Blabster\Application\UseCase\Command\User\Login\UserLoginCommand;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Blabster\Application\UseCase\Command\User\Login\UserLoginCommandResult;
use Blabster\Domain\Service\User\GetByEmail\UserByEmailGetServiceInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Blabster\Domain\Service\RefreshToken\Create\RefreshTokenCreateServiceInterface;

/**
 * @implements CommandHandlerInterface<UserLoginCommand,UserLoginCommandResult>
 */
final readonly class UserLoginCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private OtpVerifyServiceInterface $otpVerifyService,
        private JWTTokenManagerInterface $jwtManager,
        private RefreshTokenCreateServiceInterface $refreshTokenCreateService,
        private UserByEmailGetServiceInterface $userByEmailGetService,
        private UserCreateServiceInterface $userCreateService,
        private EventBusInterface $eventBus,
        private DbTransactionInterface $dbTransaction,
    ) {
        /*_*/
    }

    #[Override]
    public function __invoke(CqrsElementInterface $command): UserLoginCommandResult
    {
        return $this->dbTransaction->execute(function () use ($command) {
            $this->guardOtp($command);
            $user = $this->getUser($command);

            $refreshToken = $this->refreshTokenCreateService->perform($user);

            return new UserLoginCommandResult(
                access_token: $this->jwtManager->create($user),
                refresh_token_value: $refreshToken->getValue(),
                refresh_token_expires_at: $refreshToken->getExpiresAt(),
            );
        });
    }

    private function guardOtp(UserLoginCommand $command): void
    {
        try {
            $this->otpVerifyService->perform($command->email, $command->otp_uuid, $command->otp_code);
        } catch (InvalidArgumentException $e) {
            throw new AuthenticationException($e->getMessage(), $e->getCode(), $e);
        }
    }

    private function getUser(UserLoginCommand $command): User
    {
        $user = $this->userByEmailGetService->perform($command->email) ?? $this->userCreateService->perform($command->email);

        $this->eventBus->dispatch(...$user->pullEvents());

        return $user;
    }
}
