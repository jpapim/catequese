<?php

namespace Sacramento\Table;

use Estrutura\Table\AbstractEstruturaTable;

class SacramentoTable extends AbstractEstruturaTable{

    public $table = 'sacramento';
    public $campos = [
        'id_sacramento'=>'id', 
        'nm_sacramento'=>'nm_sacramento',
     
    ];

}