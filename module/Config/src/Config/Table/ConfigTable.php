<?php

namespace Config\Table;

use Estrutura\Table\AbstractEstruturaTable;

class ConfigTable extends AbstractEstruturaTable{

    public $table = 'config';
    public $campos = [
        'idconfigs'=>'id', 
        'nm_config'=>'nm_config', 
        'nm_valor'=>'nm_valor', 

    ];

}