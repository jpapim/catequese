<?php

namespace MovimentoPastoral\Table;

use Estrutura\Table\AbstractEstruturaTable;

class MovimentoPastoralTable extends AbstractEstruturaTable{

    public $table = 'movimento_pastoral';
    public $campos = [
        'id_movimento_pastoral'=>'id', 
        'nm_movimento_pastoral'=>'nm_movimento_pastoral',
     
    ];

}