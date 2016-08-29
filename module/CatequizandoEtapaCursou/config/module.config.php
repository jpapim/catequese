<?php

return array(
    'router' => array(
        'routes' => array(
            'catequizando_etapa_cursou-home' => array(
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route'    => '/catequizando_etapa_cursou',
                    'defaults' => array(
                        'controller' => 'catequizando_etapa_cursou',
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
            'catequizando_etapa_cursou' => 'CatequizandoEtapaCursou\Controller\CatequizandoEtapaCursouController',
            'catequizando_etapa_cursou-catequizandoetapacursou' => 'CatequizandoEtapaCursou\Controller\CatequizandoEtapaCursouController',

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
