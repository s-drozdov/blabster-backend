<?php

declare(strict_types=1);

namespace Blabster\Application\UseCase\Command\Auth\Refresh;

use Override;
use Blabster\Application\Bus\CqrsElementInterface;
use Blabster\Domain\Service\User\Refresh\UserRefreshService;
use Blabster\Application\Bus\Command\CommandHandlerInterface;
use Blabster\Application\UseCase\Command\Auth\Refresh\AuthRefreshCommand;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Blabster\Application\UseCase\Command\Auth\Refresh\AuthRefreshCommandResult;

/**
 * @implements CommandHandlerInterface<AuthRefreshCommand,AuthRefreshCommandResult>
 */
final readonly class AuthRefreshCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private UserRefreshService $userRefreshService,
        private JWTTokenManagerInterface $jwtManager,
    ) {
        /*_*/
    }

    #[Override]
    public function __invoke(CqrsElementInterface $command): AuthRefreshCommandResult
    {
        $user = $this->userRefreshService->perform($command->email, $command->refresh_token_value);

        return new AuthRefreshCommandResult(
            access_token: $this->jwtManager->create($user),
        );
    }
}
