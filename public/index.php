<?php

declare(strict_types=1);

use Blabster\Infrastructure\Bootstrap\BootstrapInterface;
use DI\Container;
use Slim\Factory\AppFactory;

/** @var Container $container */
$container = require_once __DIR__ . '/../config/bootstrap.php';

AppFactory::setContainer($container);

$app = AppFactory::create();

$container->get(BootstrapInterface::class)->perform($app);

$app->run();
