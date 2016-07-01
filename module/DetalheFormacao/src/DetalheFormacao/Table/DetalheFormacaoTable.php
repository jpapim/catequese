<?php
/**
 * Created by PhpStorm.
 * User: IGOR
 * Date: 01/07/2016
 * Time: 14:14
 */

namespace DetalheFormacao\Table;


use Estrutura\Table\AbstractEstruturaTable;

class DetalheFormacaoTable extends AbstractEstruturaTable {
    public $table ='detalhe_formacao';
    public $campos = [
      'id_detalhe_formacao'=>'id',
        'id_formacao'=>'id_formacao',
        'ds_detalhe_formacao'=>'ds_detalhe_formacao'
    ];
} 