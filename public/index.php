<?php

declare(strict_types=1);

use DI\Container;
use Slim\Factory\AppFactory;
use Blabster\Infrastructure\Http\Route\RouteRegistrarInterface;

/** @var Container $container */
$container = require_once __DIR__ . '/../config/bootstrap.php';

AppFactory::setContainer($container);

$app = AppFactory::create();

$container->get(RouteRegistrarInterface::class)->register($app);

$app->addErrorMiddleware((bool) $_ENV['APP_DEBUG'], true, true);

$app->run();
