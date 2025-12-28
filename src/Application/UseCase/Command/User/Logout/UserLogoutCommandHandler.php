<?php

declare(strict_types=1);

namespace Blabster\Application\UseCase\Command\User\Logout;

use Override;
use Blabster\Application\Bus\CqrsElementInterface;
use Blabster\Application\Bus\Event\EventBusInterface;
use Blabster\Application\Bus\Command\CommandHandlerInterface;
use Blabster\Domain\Service\User\Logout\UserLogoutServiceInterface;
use Blabster\Application\UseCase\Command\User\Logout\UserLogoutCommand;
use Blabster\Application\UseCase\Command\User\Logout\UserLogoutCommandResult;

/**
 * @implements CommandHandlerInterface<UserLogoutCommand,UserLogoutCommandResult>
 */
final readonly class UserLogoutCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private UserLogoutServiceInterface $userLogoutService,
        private EventBusInterface $eventBus,
    ) {
        /*_*/
    }

    #[Override]
    public function __invoke(CqrsElementInterface $command): UserLogoutCommandResult
    {
        $user = $this->userLogoutService->perform($command->refresh_token_value);
        $this->eventBus->dispatch(...$user->pullEvents());

        return new UserLogoutCommandResult();
    }
}
