<?php
/**
 * Created by PhpStorm.
 * User: IGOR
 * Date: 12/07/2016
 * Time: 12:48
 */

namespace SituacaoConjugal\Table;


use Estrutura\Table\AbstractEstruturaTable;

class SituacaoConjugalTable extends  AbstractEstruturaTable {

    public $table = "situacao_conjugal";
    public  $campos= [
        'id_situacao_conjugal'=>'id',
        'ds_situacao_conjugal'=>'ds_situacao_conjugal'
    ];

} 