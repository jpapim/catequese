<?php

namespace Cidade\Table;

use Estrutura\Table\AbstractEstruturaTable;

class CidadeTable extends AbstractEstruturaTable{

    public $table = 'cidade';
    public $campos = [
        'id_cidade'=>'id', 
        'id_estado'=>'id_estado', 
        'nm_cidade'=>'nm_cidade', 

    ];

}