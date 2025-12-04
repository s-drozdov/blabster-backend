<?php

declare(strict_types=1);

use Blabster\Backend\Infrastructure\Enum\AppEnvironment;

return [
    'app_name' => $_ENV['APP_NAME'],

    'jwt.secret' => $_ENV['JWT_SECRET'],
    'jwt.ttl' => (int) $_ENV['JWT_TTL'],

    'doctrine.dev_mode' => $_ENV['APP_ENV'] !== AppEnvironment::prod->value,
    'doctrine.cache_dir' => __DIR__ . '/../var/doctrine',
    'doctrine.metadata_dirs' => [__DIR__ . '/../src/Domain'],
    'doctrine.connection_string' => $_ENV['DB_CONNECTION_STRING'],
];