<?php

declare(strict_types=1);

namespace Blabster\Application\UseCase\Query\MessengerAccount;

use Override;
use Blabster\Application\Bus\CqrsElementInterface;
use Blabster\Application\Bus\Query\QueryHandlerInterface;
use Blabster\Application\UseCase\Query\MessengerAccount\MessengerAccountQuery;
use Blabster\Application\UseCase\Query\MessengerAccount\MessengerAccountQueryResult;

/**
 * @implements QueryHandlerInterface<MessengerAccountQuery,MessengerAccountQueryResult>
 */
final readonly class MessengerAccountQueryHandler implements QueryHandlerInterface
{
    #[Override]
    public function __invoke(CqrsElementInterface $query): MessengerAccountQueryResult
    {
        // TODO realization

        return new MessengerAccountQueryResult(
            login: 'test@test.com',
            password: 'test12345',
        );
    }
}
