<?php

namespace Controller\Table;

use Estrutura\Table\AbstractEstruturaTable;

class ControllerTable extends AbstractEstruturaTable{

    public $table = 'controller';
    public $campos = [
        'id_controller'=>'id', 
        'nm_controller'=>'nm_controller', 

    ];

}