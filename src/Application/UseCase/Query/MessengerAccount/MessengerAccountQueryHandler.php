<?php

declare(strict_types=1);

namespace Blabster\Application\UseCase\Query\MessengerAccount;

use Override;
use Webmozart\Assert\Assert;
use Blabster\Application\Bus\CqrsElementInterface;
use Blabster\Application\Bus\Query\QueryHandlerInterface;
use Blabster\Domain\Service\User\GetByEmail\UserByEmailGetService;
use Blabster\Application\UseCase\Query\MessengerAccount\MessengerAccountQuery;
use Blabster\Application\UseCase\Query\MessengerAccount\MessengerAccountQueryResult;

/**
 * @implements QueryHandlerInterface<MessengerAccountQuery,MessengerAccountQueryResult>
 */
final readonly class MessengerAccountQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private UserByEmailGetService $userByEmailGetService,
    ) {
        /*_*/
    }

    #[Override]
    public function __invoke(CqrsElementInterface $query): MessengerAccountQueryResult
    {
        $user = $this->userByEmailGetService->perform($query->email);
        Assert::notNull($user);

        $messengerAccount = $user->getMessengerAccount();
        Assert::notNull($messengerAccount);

        return new MessengerAccountQueryResult(
            login: $messengerAccount->getLogin(),
            password: $messengerAccount->getPassword(),
            host: $messengerAccount->getHost(),
        );
    }
}
