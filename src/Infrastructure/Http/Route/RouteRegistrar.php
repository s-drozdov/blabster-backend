<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\Http\Route;

use Slim\App;
use Blabster\Infrastructure\Http\Controller\RootAction;
use Override;

final readonly class RouteRegistrar implements RouteRegistrarInterface
{
    #[Override]
    public function register(App $app): void
    {
        $app->get('/', RootAction::class);
    }
}
