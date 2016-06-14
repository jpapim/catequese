<?php
/**
 * Created by PhpStorm.
 * User: IGOR
 * Date: 10/06/2016
 * Time: 13:14
 */

return array(
    'router' => array(
        'routes' => array(
            'detalhe_periodo_letivo' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/detalhe_periodo_letivo/:action[/:id][/:aux]',
                    'defaults' => array(
                        'controller' => 'detalhe_periodo_letivo',
                        'action'     => 'index',
                    ),
                ),

            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'detalhe_periodo_letivo' => 'DetalhePeriodoLetivo\Controller\DetalhePeriodoLetivoController',
            'detalhe_periodo_letivo-detalheperiodoletivo' => 'DetalhePeriodoLetivo\Controller\DetalhePeriodoLetivoController',
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);