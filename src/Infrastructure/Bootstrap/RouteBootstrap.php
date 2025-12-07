<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\Bootstrap;

use Blabster\Infrastructure\Http\Controller\OtpCreateAction;
use Blabster\Infrastructure\Http\Controller\RootAction;
use Override;
use Slim\App;

final readonly class RouteBootstrap implements BootstrapInterface
{
    #[Override]
    public function perform(App $app): void
    {
        $app->get('/', RootAction::class);

        $app->post('/otp', OtpCreateAction::class);
    }
}
