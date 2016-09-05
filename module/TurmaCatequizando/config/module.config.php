<?php

return array(
    'router' => array(
        'routes' => array(
            'turma_catequizando-home' => array(
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route'    => '/turma_catequizando',
                    'defaults' => array(
                        'controller' => 'turma_catequizando',
                        'action'     => 'index',
                    ),
                ),
            ),
            'turma_catequizando' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/turma_catequizando/:action[/:id_turma][/:id_periodo_letivo][/:id_turma_catequizando]',
                    'defaults' => array(
                        'controller' => 'turma_catequizando-turmacatequizando',
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
            'turma_catequizando' => 'TurmaCatequizando\Controller\TurmaCatequizandoController',
            'turma_catequizando-turmacatequizando' => 'TurmaCatequizando\Controller\TurmaCatequizandoController',

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

