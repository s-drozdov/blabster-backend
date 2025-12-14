<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\OpenApi\Schema\UseCase\Command\Auth\Refresh;

use OpenApi\Attributes as OA;

/**
 * @psalm-suppress MissingConstructor
 */
#[OA\Schema()]
final class AuthRefreshCommand
{
    public string $email;
}
