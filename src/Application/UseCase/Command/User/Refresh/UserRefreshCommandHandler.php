<?php

declare(strict_types=1);

namespace Blabster\Application\UseCase\Command\User\Refresh;

use Override;
use Blabster\Application\Bus\CqrsElementInterface;
use Blabster\Application\Bus\Event\EventBusInterface;
use Blabster\Application\Bus\Command\CommandHandlerInterface;
use Blabster\Application\UseCase\Command\User\Refresh\UserRefreshCommand;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Blabster\Application\UseCase\Command\User\Refresh\UserRefreshCommandResult;
use Blabster\Domain\Service\User\GetByRefresh\UserByRefreshGetServiceInterface;

/**
 * @implements CommandHandlerInterface<UserRefreshCommand,UserRefreshCommandResult>
 */
final readonly class UserRefreshCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private UserByRefreshGetServiceInterface $userByRefreshGetService,
        private JWTTokenManagerInterface $jwtManager,
        private EventBusInterface $eventBus,
    ) {
        /*_*/
    }

    #[Override]
    public function __invoke(CqrsElementInterface $command): UserRefreshCommandResult
    {
        $user = $this->userByRefreshGetService->perform($command->refresh_token_value);
        $this->eventBus->dispatch(...$user->pullEvents());

        return new UserRefreshCommandResult(
            access_token: $this->jwtManager->create($user),
        );
    }
}
