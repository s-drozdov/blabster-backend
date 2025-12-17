<?php

declare(strict_types=1);

namespace Blabster\Application\UseCase\Command\Auth\LogoutAll;

use Override;
use Blabster\Application\Bus\CqrsElementInterface;
use Blabster\Domain\Service\User\LogoutAll\UserLogoutAllService;
use Blabster\Application\Bus\Command\CommandHandlerInterface;
use Blabster\Application\UseCase\Command\Auth\LogoutAll\AuthLogoutAllCommand;
use Blabster\Application\UseCase\Command\Auth\LogoutAll\AuthLogoutAllCommandResult;

/**
 * @implements CommandHandlerInterface<AuthLogoutAllCommand,AuthLogoutAllCommandResult>
 */
final readonly class AuthLogoutAllCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private UserLogoutAllService $userLogoutAllService,
    ) {
        /*_*/
    }

    #[Override]
    public function __invoke(CqrsElementInterface $command): AuthLogoutAllCommandResult
    {
        $this->userLogoutAllService->perform($command->email, $command->refresh_token_value);

        return new AuthLogoutAllCommandResult();
    }
}
