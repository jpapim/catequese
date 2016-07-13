<?php

return array(
    'router' => array(
        'routes' => array(
            'situacao_responsavel-home' => array(
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route'    => '/situacao_responsavel',
                    'defaults' => array(
                        'controller' => 'situacao_responsavel',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),

    'controllers' => array(
        'invokables' => array(
            'situacao_responsavel' => 'SituacaoResponsavel\Controller\SituacaoResponsavelController',
            'situacao_responsavel-situacaoresponsavel' => 'SituacaoResponsavel\Controller\SituacaoResponsavelController',

        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    // Placeholder for console routes

);
