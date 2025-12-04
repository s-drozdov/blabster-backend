<?php

declare(strict_types=1);

use DI\Container;
use function DI\create;
use Doctrine\ORM\ORMSetup;
use Doctrine\ORM\EntityManager;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Tools\DsnParser;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Blabster\Backend\Infrastructure\Http\Route\RouteRegistrar;
use Blabster\Backend\Infrastructure\Http\Route\RouteRegistrarInterface;

return [
    RouteRegistrarInterface::class => create(RouteRegistrar::class),
    
    EntityManager::class => static function (Container $container): EntityManager {
        $cache = new FilesystemAdapter(directory: $container->get('doctrine.cache_dir'));

        $config = ORMSetup::createAttributeMetadataConfiguration(
            $container->get('doctrine.metadata_dirs'),
            $container->get('doctrine.dev_mode'),
            null,
            $cache,
        );

        $parser = new DsnParser();

        $connection = DriverManager::getConnection(
            $parser->parse($container->get('doctrine.connection_string')), 
            $config,
        );

        return new EntityManager($connection, $config);
    },
];