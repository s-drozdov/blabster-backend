<?php

declare(strict_types=1);

namespace Blabster\Application\EventHandler\MessengerAccount\Registered;

use Blabster\Library\SDK\Ejabberd\EjabberdSdkInterface;
use Blabster\Application\Bus\Event\EventHandlerInterface;
use Blabster\Domain\Event\User\MessengerAccountRegistered;
use Blabster\Library\SDK\Ejabberd\Enum\RosterSubscriptionStatus;
use Blabster\Library\SDK\Ejabberd\Request\AddRosterItemRequestDto;

/**
 * @implements EventHandlerInterface<MessengerAccountRegistered>
 */
final readonly class AddUserContactToAdminRoster implements EventHandlerInterface
{
    public function __construct(
        private EjabberdSdkInterface $ejabberdSdk,
        private string $messengerHost,
        private string $adminContactLogin,
        private string $adminContactGroup,
    ) {
        /*_*/
    }

    public function __invoke(MessengerAccountRegistered $event): void
    {
        $requestDto = new AddRosterItemRequestDto(
            localuser: $this->adminContactLogin,
            localhost: $this->messengerHost,
            user: $event->login,
            host: $event->host,
            nick: $event->login,
            groups: [$this->adminContactGroup],
            subs: RosterSubscriptionStatus::EveryoneSee->value,
        );

        $this->ejabberdSdk->addRosterItem($requestDto);
    }
}
