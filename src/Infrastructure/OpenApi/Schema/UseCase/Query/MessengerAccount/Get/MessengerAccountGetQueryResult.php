<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\OpenApi\Schema\UseCase\Query\MessengerAccount\Get;

use OpenApi\Attributes as OA;

/**
 * @psalm-suppress MissingConstructor
 */
#[OA\Schema()]
final class MessengerAccountGetQueryResult
{
    public string $login;
    public string $password;
    public string $host;
}
