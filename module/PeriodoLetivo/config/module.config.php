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
            'periodo_letivo' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/periodo_letivo/:action[/:id][/:aux]',
                    'defaults' => array(
                        'controller' => 'periodo_letivo',
                        'action'     => 'index',
                    ),
                ),

            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'periodo_letivo' => 'PeriodoLetivo\Controller\PeriodoLetivoController',
            'periodo_letivo-periodoletivo' => 'PeriodoLetivo\Controller\PeriodoLetivoController',
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);