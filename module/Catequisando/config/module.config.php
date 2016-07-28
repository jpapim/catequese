<?php

return array(
    'router' => array(
        'routes' => array(
            'catequisando-home' => array(
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route'    => '/catequisando/:action[/:id][/:aux]',
                    'defaults' => array(
                        'controller' => 'catequisando',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),

    'controllers' => array(
        'invokables' => array(
            'catequisando' => 'Catequisando\Controller\CatequisandoController',
            'catequisando-catequisando' => 'Catequisando\Controller\CatequisandoController',

        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),

);
