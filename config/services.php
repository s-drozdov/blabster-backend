<?php

declare(strict_types=1);

use function DI\get;
use function DI\create;
use function DI\autowire;
use Slim\Factory\AppFactory;
use Doctrine\ORM\EntityManager;
use Blabster\Infrastructure\Bus\CqrsBus;
use Blabster\Infrastructure\Bus\QueryBus;
use Blabster\Infrastructure\Bus\CommandBus;
use Psr\Http\Message\ResponseFactoryInterface;
use Blabster\Infrastructure\Bootstrap\Bootstrap;
use Blabster\Infrastructure\Bus\CqrsBusInterface;
use Blabster\Infrastructure\Bus\QueryBusInterface;
use Blabster\Infrastructure\Bus\CommandBusInterface;
use Blabster\Infrastructure\Bootstrap\ErrorBootstrap;
use Blabster\Infrastructure\Bootstrap\RouteBootstrap;
use Blabster\Infrastructure\Repository\UserRepository;
use Blabster\Domain\Repository\UserRepositoryInterface;
use Blabster\Infrastructure\Bootstrap\BootstrapInterface;
use Blabster\Infrastructure\Bootstrap\MiddlewareBootstrap;
use Blabster\Infrastructure\Http\RequestResolver\RequestResolver;
use Blabster\Infrastructure\Http\RequestResolver\RequestResolverInterface;

$cqrsElementToHandlerMap = require_once(__DIR__ . '/bus/handlers.php');

$servicesConfig = [
    BootstrapInterface::class => autowire(Bootstrap::class)
        ->constructorParameter('bootstrapList', [
            autowire(RouteBootstrap::class),
            autowire(ErrorBootstrap::class)
                ->constructorParameter('isDebug', get('app.is_debug')),
            autowire(MiddlewareBootstrap::class)
                ->constructorParameter(
                    'middlewareList', 
                    array_map(
                        fn (string $fqcn) => autowire($fqcn),
                        require_once(__DIR__ . '/middleware.php'),
                    ),
                ),
        ]),

    ResponseFactoryInterface::class => AppFactory::determineResponseFactory(),

    CqrsBusInterface::class => autowire(CqrsBus::class)
        ->constructorParameter('cqrsElementToBusMap', require_once(__DIR__ . '/bus/bus.php')),

    QueryBusInterface::class => autowire(QueryBus::class)
        ->constructorParameter('cqrsElementToHandlerMap', $cqrsElementToHandlerMap),

    CommandBusInterface::class => autowire(CommandBus::class)
        ->constructorParameter('cqrsElementToHandlerMap', $cqrsElementToHandlerMap),

    RequestResolverInterface::class => autowire(RequestResolver::class)
        ->constructorParameter(
            'cqrsElementToResolverMap',
            require_once(__DIR__ . '/bus/requests.php'),
        ),


    UserRepositoryInterface::class => create(UserRepository::class)
        ->constructor(get(EntityManager::class)),
];

return array_merge(
    require_once(__DIR__ . '/doctrine.php'),
    $servicesConfig,
);
