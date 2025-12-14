<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\OpenApi\Schema\UseCase\Command\Auth\Refresh;

use OpenApi\Attributes as OA;

/**
 * @psalm-suppress MissingConstructor
 */
#[OA\Schema()]
final class AuthRefreshCommandResult
{
    public string $access_token;
}
