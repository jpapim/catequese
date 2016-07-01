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
            'formacao-home' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => 'formacao/:action[/:id][/:aux]',
                    'defaults' => array(
                        'controller' => 'formacao-formacao',
                        'action'     => 'index',
                    ),
                ),

            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'formacao' => 'Formacao\Controller\FormacaoController',
            'formacao-formacao' => 'Formacao\Controller\FormacaoController',
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);