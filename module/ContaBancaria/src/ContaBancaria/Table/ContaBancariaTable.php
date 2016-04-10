<?php

namespace ContaBancaria\Table;

use Estrutura\Table\AbstractEstruturaTable;

class ContaBancariaTable extends AbstractEstruturaTable{

    public $table = 'conta_bancaria';
    public $campos = [
        'id_conta_bancaria'=>'id', 
        'nr_agencia'=>'nr_agencia', 
        'nr_conta'=>'nr_conta', 
        'id_situacao'=>'id_situacao', 
        'id_usuario'=>'id_usuario', 
        'id_banco'=>'id_banco', 
        'id_tipo_conta'=>'id_tipo_conta', 

    ];

}