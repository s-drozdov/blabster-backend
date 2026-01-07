<?php

declare(strict_types=1);

namespace Blabster\Application\UseCase\Query\MessengerAccount\Get;

use Override;
use Webmozart\Assert\Assert;
use Blabster\Application\Bus\CqrsElementInterface;
use Blabster\Application\Bus\Query\QueryHandlerInterface;
use Blabster\Domain\Service\User\GetByEmail\UserByEmailGetServiceInterface;
use Blabster\Application\UseCase\Query\MessengerAccount\Get\MessengerAccountGetQuery;
use Blabster\Application\UseCase\Query\MessengerAccount\Get\MessengerAccountGetQueryResult;

/**
 * @implements QueryHandlerInterface<MessengerAccountGetQuery,MessengerAccountGetQueryResult>
 */
final readonly class MessengerAccountGetQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private UserByEmailGetServiceInterface $userByEmailGetService,
    ) {
        /*_*/
    }

    #[Override]
    public function __invoke(CqrsElementInterface $query): MessengerAccountGetQueryResult
    {
        $user = $this->userByEmailGetService->perform($query->email);
        Assert::notNull($user);

        $messengerAccount = $user->getMessengerAccount();
        Assert::notNull($messengerAccount);

        return new MessengerAccountGetQueryResult(
            login: $messengerAccount->getLogin(),
            password: $messengerAccount->getPassword(),
            host: $messengerAccount->getHost(),
        );
    }
}
