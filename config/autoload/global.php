<?php

return [
    'db' => array(
        'driver' => 'Pdo',
        'driver_options' => array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
        ),
    ),
    'nomeProjeto' => '',
    'general' => [
        'arquivos' => BASE_PATCH . '/data/arquivos/',
    ],
    'service_manager' => array(
        'factories' => array(
            'Zend\Db\Adapter\Adapter' => 'Zend\Db\Adapter\AdapterServiceFactory',
            'Zend\Cache\Storage\Filesystem' => function($sm) {
                $cache = \Zend\Cache\StorageFactory::factory(array(
                    'adapter' => array(
                        'name' => 'filesystem',
                        'options' => array(
                            // tempo de validade do cache
                            'ttl' => 3600,
                            // adicionando o diretorio data/cache para salvar os caches.
                            'cacheDir' => './data/cache'
                        ),
                    ),
                    'plugins' => array(
                        'exception_handler' => array('throw_exceptions' => false),
                        'Serializer'
                    )
                ));

                return $cache;
            },
        ),
    ),
    'view_manager' => array(
        'strategies' => array(
           'ViewJsonStrategy',
        ),
    ),
];
