<?php
/**
 * Created by PhpStorm.
 * User: IGOR
 * Date: 08/06/2016
 * Time: 13:48
 */
return array(
    'router' => array(
        'routes' => array(
            'album' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/periodo_letivo-periodoletivo',
                    'defaults' => array(
                        'controller' => 'periodo_letivo-periodoletivo',
                        'action'     => 'index',
                    ),
                ),

            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'periodo_letivo-periodoletivo' => 'PeriodoLetivo\Controller\PeriodoLetivoController',
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);