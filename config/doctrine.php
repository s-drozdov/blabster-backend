<?php

declare(strict_types=1);

use DI\Container;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Tools\DsnParser;
use Doctrine\ORM\Mapping\Driver\XmlDriver;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

return [
    EntityManager::class => static function (Container $container): EntityManager {
        $proxyDir = $container->get('doctrine.proxy.path');
        $cache = new FilesystemAdapter(directory: $container->get('doctrine.cache.path'));

        $config = new Configuration();

        $config->setMetadataCache($cache);
        $config->setQueryCache($cache);
        $config->setResultCache($cache);
        $config->setProxyDir($proxyDir);
        $config->setProxyNamespace('DoctrineProxies');
        $config->setAutoGenerateProxyClasses($container->get('doctrine.is_dev_mode'));

        $config->setMetadataDriverImpl(
            new XmlDriver(
                $container->get('doctrine.mapping.path'), 
                XmlDriver::DEFAULT_FILE_EXTENSION,
                true,
            ),
        );

        $parser = new DsnParser();

        $connection = DriverManager::getConnection(
            $parser->parse($container->get('doctrine.connection.url')), 
            $config,
        );

        return new EntityManager($connection, $config);
    },
];