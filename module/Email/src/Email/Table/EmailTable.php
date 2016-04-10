<?php

namespace Email\Table;

use Estrutura\Table\AbstractEstruturaTable;

class EmailTable extends AbstractEstruturaTable{

    public $table = 'email';
    public $campos = [
        'id_email'=>'id', 
        'em_email'=>'em_email', 
        'id_situacao'=>'id_situacao', 

    ];

}