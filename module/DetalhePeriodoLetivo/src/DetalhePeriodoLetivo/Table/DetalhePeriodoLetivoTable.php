<?php
/**
 * Created by PhpStorm.
 * User: IGOR
 * Date: 10/06/2016
 * Time: 13:20
 */

namespace DetalhePeriodoLetivo\Table;


use Estrutura\Table\AbstractEstruturaTable;

class DetalhePeriodoLetivoTable extends AbstractEstruturaTable{

    public $table='detalhe_periodo_letivo';
    public $campos= [
        'id_detalhe_periodo_letivo'=>'id',
        'id_periodo_letivo'=>'id_periodo_letivo',
        'dt_encontro'=>'dt_encontro',
    ];
} 