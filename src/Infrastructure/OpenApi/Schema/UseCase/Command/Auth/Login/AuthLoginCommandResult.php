<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\OpenApi\Schema\UseCase\Command\Auth\Login;

use OpenApi\Attributes as OA;

/**
 * @psalm-suppress MissingConstructor
 */
#[OA\Schema()]
final class AuthLoginCommandResult
{
    public string $access_token;
}
