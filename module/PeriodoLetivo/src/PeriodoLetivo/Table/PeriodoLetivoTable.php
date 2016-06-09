<?php
/**
 * Created by PhpStorm.
 * User: IGOR
 * Date: 08/06/2016
 * Time: 13:58
 */

namespace PeriodoLetivo\Table;


use Estrutura\Table\AbstractEstruturaTable;

class PeriodoLetivoTable extends AbstractEstruturaTable{

        public $table='periodo_letivo';
        public $campos= [
            'id_periodo_letivo'=>'id',
            'dt_inicio'=>'inicio',
            'dt_fim'=>'fim',
            'dt_ano_letivo'=>'ano_letivo',
        ];

} 