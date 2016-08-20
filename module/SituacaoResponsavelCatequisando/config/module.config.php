<?php

return array(
    'router' => array(
        'routes' => array(
            'situacao_responsavel-catequisando-home' => array(
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route'    => '/situacao_responsavel_catequisando',
                    'defaults' => array(
                        'controller' => 'situacao_responsavel_catequisando',
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
            'situacao_responsavel_catequisando' => 'SituacaoResponsavelCatequisando\Controller\SituacaoResponsavelCatequisandoController',
            'situacao_responsavel_catequisando-situacaoresponsavelcatequisando' => 'SituacaoResponsavelCatequisando\Controller\SituacaoResponsavelCatequisandoController',

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
