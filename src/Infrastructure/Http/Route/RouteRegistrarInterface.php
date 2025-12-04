<?php

declare(strict_types=1);

namespace Blabster\Backend\Infrastructure\Http\Route;

use Slim\App;
use Psr\Container\ContainerInterface;

interface RouteRegistrarInterface
{
    /**
     * @param App<ContainerInterface> $app
     */
    public function register(App $app): void;
}
