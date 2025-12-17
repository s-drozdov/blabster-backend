<?php

declare(strict_types=1);

namespace Blabster\Application\UseCase\Command\Auth\Logout;

use Override;
use Blabster\Application\Bus\CqrsElementInterface;
use Blabster\Domain\Service\User\Logout\UserLogoutService;
use Blabster\Application\Bus\Command\CommandHandlerInterface;
use Blabster\Application\UseCase\Command\Auth\Logout\AuthLogoutCommand;
use Blabster\Application\UseCase\Command\Auth\Logout\AuthLogoutCommandResult;

/**
 * @implements CommandHandlerInterface<AuthLogoutCommand,AuthLogoutCommandResult>
 */
final readonly class AuthLogoutCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private UserLogoutService $userLogoutService,
    ) {
        /*_*/
    }

    #[Override]
    public function __invoke(CqrsElementInterface $command): AuthLogoutCommandResult
    {
        $this->userLogoutService->perform($command->email, $command->refresh_token_value);

        return new AuthLogoutCommandResult();
    }
}
