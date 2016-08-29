<?php

return array(
    'router' => array(
        'routes' => array(
            'catequizando-home' => array(
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route'    => '/catequizando/:action[/:id][/:aux]',
                    'defaults' => array(
                        'controller' => 'catequizando',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),

    'controllers' => array(
        'invokables' => array(
            'catequizando' => 'Catequizando\Controller\CatequizandoController',
            'catequizando-catequizando' => 'Catequizando\Controller\CatequizandoController',

        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),

);
