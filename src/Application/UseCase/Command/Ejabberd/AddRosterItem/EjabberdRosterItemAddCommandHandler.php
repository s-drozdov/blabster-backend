<?php

declare(strict_types=1);

namespace Blabster\Application\UseCase\Command\Ejabberd\AddRosterItem;

use Override;
use Blabster\Application\Bus\CqrsElementInterface;
use Blabster\Library\SDK\Ejabberd\EjabberdSdkInterface;
use Blabster\Application\Bus\Command\CommandHandlerInterface;
use Blabster\Library\SDK\Ejabberd\Request\AddRosterItemRequestDto;

/**
 * @implements CommandHandlerInterface<EjabberdRosterItemAddCommand,EjabberdRosterItemAddCommandResult>
 */
final readonly class EjabberdRosterItemAddCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private EjabberdSdkInterface $ejabberdSdk,
    ) {
        /*_*/
    }

    #[Override]
    public function __invoke(CqrsElementInterface $command): EjabberdRosterItemAddCommandResult
    {
        $requestDto = new AddRosterItemRequestDto(
            localuser: $command->localuser,
            localhost: $command->localhost,
            user: $command->user,
            host: $command->host,
            nick: $command->nick,
            groups: $command->group_list,
            subs: $command->subs,
        );

        $this->ejabberdSdk->addRosterItem($requestDto);

        return new EjabberdRosterItemAddCommandResult();
    }
}
