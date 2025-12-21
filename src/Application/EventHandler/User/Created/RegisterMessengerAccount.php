<?php

declare(strict_types=1);

namespace Blabster\Application\EventHandler\User\Created;

use Blabster\Domain\Event\User\UserCreated;
use Blabster\Domain\Helper\Uuid\UuidHelperInterface;
use Blabster\Application\Bus\Event\EventBusInterface;
use Blabster\Library\SDK\Ejabberd\EjabberdSdkInterface;
use Blabster\Domain\Helper\String\StringHelperInterface;
use Blabster\Application\Bus\Event\EventHandlerInterface;
use Blabster\Library\SDK\Ejabberd\Request\RegisterRequestDto;
use Blabster\Library\SDK\Ejabberd\Request\CheckAccountRequestDto;
use Blabster\Domain\Service\User\GetByUuid\UserByUuidGetServiceInterface;
use Blabster\Domain\Service\MessengerAccount\Create\MessengerAccountCreateService;
use Blabster\Domain\Service\MessengerAccount\Create\MessengerAccountCreateServiceInterface;

/**
 * @implements EventHandlerInterface<UserCreated>
 */
final readonly class RegisterMessengerAccount implements EventHandlerInterface
{
    private const int LOGIN_RESOLVE_TRY_LIMIT = 10;
    private const int PASSWORD_LENGTH = 8;
    private const string PASSWORD_SYMBOLS = '!@()';

    public function __construct(
        private UserByUuidGetServiceInterface $userByUuidGetService,
        private EjabberdSdkInterface $ejabberdSdk,
        private StringHelperInterface $stringHelper,
        private UuidHelperInterface $uuidHelper,
        private MessengerAccountCreateServiceInterface $messengerAccountCreateService,
        private EventBusInterface $eventBus,
        private string $messengerHost,
    ) {
        /*_*/
    }

    public function __invoke(UserCreated $event): void
    {
        $user = $this->userByUuidGetService->perform($event->uuid);
        $emailLocalPath = $this->stringHelper->getLocalPartFromEmail($user->getEmail());
        
        $login = $this->getFreeLogin($emailLocalPath);
        $password = $this->stringHelper->generateMessengerPassword(self::PASSWORD_LENGTH, self::PASSWORD_SYMBOLS);

        $this->registerMessengerAccount($login, $password);

        $this->messengerAccountCreateService->perform($user, $login, $password, $this->messengerHost);
        $this->eventBus->dispatch(...$user->pullEvents());
    }

    private function getFreeLogin(string $loginExample): string
    {
        for ($i = 0; $i < self::LOGIN_RESOLVE_TRY_LIMIT; ++$i) {
            $login = sprintf(
                '%s%s', 
                $loginExample, 
                $i === 0 ? '' : sprintf('_%d', $i),
            );

            if ($this->isLoginFree($login)) {
                return $login;
            }
        }

        return sprintf(
            '%s_%s',
            $loginExample,
            (string) $this->uuidHelper->create(),
        );
    }

    private function isLoginFree(string $login): bool
    {
        $requestDto = new CheckAccountRequestDto(
            user: $login,
            host: $this->messengerHost,
        );

        $responseDto = $this->ejabberdSdk->checkAccount($requestDto);

        return !$responseDto->is_user_exist;
    }

    private function registerMessengerAccount(string $login, string $password): void
    {

        $requestDto = new RegisterRequestDto(
            user: $login,
            host: $this->messengerHost,
            password: $password,
        );

        $this->ejabberdSdk->register($requestDto);
    }
}
