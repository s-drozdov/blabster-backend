<?php

declare(strict_types=1);

use Blabster\Infrastructure\Enum\AppEnvironment;

return [
    'app.name' => $_ENV['APP_NAME'],
    'app.is_debug' => (bool) $_ENV['APP_DEBUG'],

    'jwt.secret' => $_ENV['JWT_SECRET'],
    'jwt.ttl' => (int) $_ENV['JWT_TTL'],

    'doctrine.is_dev_mode' => $_ENV['APP_ENV'] !== AppEnvironment::prod->value,
    'doctrine.cache.path' => __DIR__ . '/../var/doctrine/cache',
    'doctrine.proxy.path' => __DIR__ . '/../var/doctrine/proxy',
    'doctrine.mapping.path' => [__DIR__ . '/../src/Infrastructure/Resources/doctrine/mapping'],
    'doctrine.connection.url' => $_ENV['DB_CONNECTION_STRING'],
];