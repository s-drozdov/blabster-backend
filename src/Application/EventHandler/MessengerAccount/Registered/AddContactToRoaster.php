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
final readonly class AddContactToRoaster implements EventHandlerInterface
{
    private const array DEFAULT_GROUPS = [];

    public function __construct(
        private EjabberdSdkInterface $ejabberdSdk,
        private string $messengerHost,
        private string $requiredContactLogin,
        private string $requiredContactNickname,
    ) {
        /*_*/
    }

    public function __invoke(MessengerAccountRegistered $event): void
    {
        $requestDto = new AddRosterItemRequestDto(
            localuser: $event->login,
            localhost: $event->host,
            user: $this->requiredContactLogin,
            host: $this->messengerHost,
            nick: $this->requiredContactNickname,
            groups: self::DEFAULT_GROUPS,
            subs: RosterSubscriptionStatus::EveryoneSee->value,
        );

        $this->ejabberdSdk->addRosterItem($requestDto);
    }
}
