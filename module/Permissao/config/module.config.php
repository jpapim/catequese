<?php

return array(
    'router' => array(
        'routes' => array(
            'permissao' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/permissao-permissao/:action[/:aux][/:aux2]',
                    'defaults' => array(
                        'controller' => 'permissao-permissao',
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
            'permissao' => 'Permissao\Controller\PermissaoController',
            'permissao-permissao' => 'Permissao\Controller\PermissaoController',

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
