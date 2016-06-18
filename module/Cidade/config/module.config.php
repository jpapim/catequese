<?php

return array(
    'router' => array(
        'routes' => array(
            'navegacao' => array(
                'type' => 'Segment',
                'options' => array(
                    'route'    => '/:controller[/:action[/:id]]',
                    'defaults' => array(
                        'action'     => 'index',
                    ),
                ),
            ),
            'cidade-home' => array(
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route'    => '/cidade',
                    'defaults' => array(
                        'controller' => 'cidade',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
        'aliases' => array(
            'translator' => 'MvcTranslator',
        ),
    ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'cidade' => 'Cidade\Controller\CidadeController',
            'cidade-cidade' => 'Cidade\Controller\CidadeController',

        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array(
            ),
        ),
    ),
);
