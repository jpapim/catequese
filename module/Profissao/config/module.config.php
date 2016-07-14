<?php
/**
 * Created by PhpStorm.
 * User: IGOR
 * Date: 12/07/2016
 * Time: 12:27
 */


return array(
    'router' => array(
        'routes' => array(
            'profissao-home' => array(
                'type' => 'Segment',
                'options' => array(
                    'route'    => 'profissao/:action[/:id][/:aux]',
                    'defaults' => array(
                        'controller' => 'profissao',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),

    'controllers' => array(
        'invokables' => array(
            'profissao' => 'Profissao\Controller\ProfissaoController',
            'profissao-profissao' => 'Profissao\Controller\ProfissaoController',

        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),

);



