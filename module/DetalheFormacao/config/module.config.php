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
            'detalhe_formacao-home' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => 'detalhe_formacao/:action[/:id][/:aux]',
                    'defaults' => array(
                        'controller' => 'detalhe_formacao',
                        'action'     => 'index',
                    ),
                ),

            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'detalhe_formacao' => 'DetalheFormacao\Controller\DetalheFormacaoController',
                ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);