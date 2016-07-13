<?php
/**
 * Created by PhpStorm.
 * User: IGOR
 * Date: 14/07/2016
 * Time: 12:56
 */

namespace SituacaoResponsavel\Table;


use Estrutura\Table\AbstractEstruturaTable;

class SituacaoResponsavelTable extends  AbstractEstruturaTable {

    public $table= "situacao_responsavel";
    public $campos = [
        'id_situacao_responsavel'=>'id',
        'ds_situacao_responsavel'=>'ds_situacao_responsavel',
        'cs_pai_mae'=>'cs_pai_mae'
    ];

} 