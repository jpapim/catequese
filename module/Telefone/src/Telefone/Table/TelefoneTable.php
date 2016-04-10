<?php

namespace Telefone\Table;

use Estrutura\Table\AbstractEstruturaTable;

class TelefoneTable extends AbstractEstruturaTable{

    public $table = 'telefone';
    public $campos = [
        'id_telefone'=>'id', 
        'nr_ddd_telefone'=>'nr_ddd_telefone', 
        'nr_telefone'=>'nr_telefone', 
        'id_tipo_telefone'=>'id_tipo_telefone', 
        'id_situacao'=>'id_situacao', 

    ];

}