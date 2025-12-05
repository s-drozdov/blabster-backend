<?php

declare(strict_types=1);

use function DI\create;
use function DI\get;
use Doctrine\ORM\EntityManager;
use Blabster\Infrastructure\Http\Route\RouteRegistrar;
use Blabster\Infrastructure\Repository\UserRepository;
use Blabster\Domain\Repository\UserRepositoryInterface;
use Blabster\Infrastructure\Http\Route\RouteRegistrarInterface;

$servicesConfig = [
    RouteRegistrarInterface::class => create(RouteRegistrar::class),

    UserRepositoryInterface::class => create(UserRepository::class)
        ->constructor(get(EntityManager::class)),
];

return array_merge(
    require_once(__DIR__ . '/doctrine.php'),
    $servicesConfig,
);