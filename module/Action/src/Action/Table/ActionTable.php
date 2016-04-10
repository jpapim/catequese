<?php

namespace Action\Table;

use Estrutura\Table\AbstractEstruturaTable;

class ActionTable extends AbstractEstruturaTable{

    public $table = 'action';
    public $campos = [
        'id_action'=>'id', 
        'nm_action'=>'nm_action', 

    ];

}