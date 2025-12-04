<?php

declare(strict_types=1);

use DI\Container;
use Dotenv\Dotenv;

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$definitions = require __DIR__ . '/../config/definitions.php';
$services = require __DIR__ . '/../config/services.php';

return new Container(
    array_merge($definitions, $services),
);
