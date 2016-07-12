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
            'situacao_conjugal-home' => array(
                'type' => 'Segment',
                'options' => array(
                    'route'    => 'situacao_conjugal/:action[/:id][/:aux]',
                    'defaults' => array(
                        'controller' => 'situacao_conjugal',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),

    'controllers' => array(
        'invokables' => array(
            'situacao-conjugal' => 'SituacaoConjugal\Controller\SituacaoConjugalController',
            'situacao_conjugal-situacaoconjugal' => 'SituacaoConjugal\Controller\SituacaoConjugalController',

        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),

);



