<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\OpenApi\Schema\UseCase\Query\MessengerAccount;

use OpenApi\Attributes as OA;

/**
 * @psalm-suppress MissingConstructor
 */
#[OA\Schema()]
final class MessengerAccountQueryResult
{
    public string $login;
    public string $password;
    public string $host;
}
