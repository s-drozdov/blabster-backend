<?php

declare(strict_types=1);

namespace Blabster\Application\UseCase\Command\Auth\Login;

use Override;
use Webmozart\Assert\Assert;
use InvalidArgumentException;
use Blabster\Domain\Entity\User\User;
use Blabster\Application\Bus\CqrsElementInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Blabster\Domain\Service\Otp\Verify\OtpVerifyService;
use Blabster\Domain\Service\User\Login\UserLoginService;
use Blabster\Application\Bus\Command\CommandHandlerInterface;
use Blabster\Application\UseCase\Command\Auth\Login\AuthLoginCommand;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Blabster\Domain\Service\RefreshToken\Create\RefreshTokenCreateService;
use Blabster\Application\UseCase\Command\Auth\Login\AuthLoginCommandResult;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;

/**
 * @implements CommandHandlerInterface<AuthLoginCommand,AuthLoginCommandResult>
 */
final readonly class AuthLoginCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private OtpVerifyService $otpVerifyService,
        private UserLoginService $userLoginService,
        private JWTTokenManagerInterface $jwtManager,
        private RefreshTokenCreateService $refreshTokenCreateService,
    ) {
        /*_*/
    }

    #[Override]
    public function __invoke(CqrsElementInterface $command): AuthLoginCommandResult
    {
        $user = $this->authenticate($command);
        $refreshToken = $this->refreshTokenCreateService->perform($user);

        return new AuthLoginCommandResult(
            access_token: $this->jwtManager->create($user),
            refresh_token_value: $refreshToken->getValue(),
            refresh_token_expires_at: $refreshToken->getExpiresAt(),
        );
    }

    private function authenticate(AuthLoginCommand $command): User
    {
        try {
            Assert::notNull($command->otp_uuid);
            $this->otpVerifyService->perform($command->email, $command->otp_uuid, $command->otp_code);
        } catch (InvalidArgumentException $e) {
            throw new AuthenticationException($e->getMessage(), $e->getCode(), $e);
        }

        return $this->userLoginService->perform($command->email);
    }
}
