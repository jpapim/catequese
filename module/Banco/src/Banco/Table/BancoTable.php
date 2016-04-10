<?php

namespace Banco\Table;

use Estrutura\Table\AbstractEstruturaTable;

class BancoTable extends AbstractEstruturaTable{

    public $table = 'banco';
    public $campos = [
        'id_banco'=>'id', 
        'nm_banco'=>'nm_banco',
    ];

}