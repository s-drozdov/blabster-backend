<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\Bootstrap;

use Slim\App;
use Psr\Container\ContainerInterface;

interface BootstrapInterface
{
    /**
     * @param App<ContainerInterface> $app
     */
    public function perform(App $app): void;
}
