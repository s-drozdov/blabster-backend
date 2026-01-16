<?php

declare(strict_types=1);

namespace Blabster\Application\UseCase\Command\User\LogoutAll;

use Override;
use Blabster\Application\Bus\CqrsElementInterface;
use Blabster\Application\Bus\Event\EventBusInterface;
use Blabster\Application\Bus\Command\CommandHandlerInterface;
use Blabster\Domain\Service\User\LogoutAll\UserLogoutAllServiceInterface;
use Blabster\Application\UseCase\Command\User\LogoutAll\UserLogoutAllCommand;
use Blabster\Application\UseCase\Command\User\LogoutAll\UserLogoutAllCommandResult;

/**
 * @implements CommandHandlerInterface<UserLogoutAllCommand,UserLogoutAllCommandResult>
 */
final readonly class UserLogoutAllCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private UserLogoutAllServiceInterface $userLogoutAllService,
        private EventBusInterface $eventBus,
    ) {
        /*_*/
    }

    #[Override]
    public function __invoke(CqrsElementInterface $command): UserLogoutAllCommandResult
    {
        if ($command->refresh_token_value !== null) {
            $user = $this->userLogoutAllService->perform($command->refresh_token_value);
            $this->eventBus->dispatch(...$user->pullEvents());
        }

        return new UserLogoutAllCommandResult();
    }
}
