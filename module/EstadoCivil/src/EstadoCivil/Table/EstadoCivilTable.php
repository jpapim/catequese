<?php

namespace EstadoCivil\Table;

use Estrutura\Table\AbstractEstruturaTable;

class EstadoCivilTable extends AbstractEstruturaTable{

    public $table = 'estado_civil';
    public $campos = [
        'id_estado_civil'=>'id', 
        'nm_estado_civil'=>'nm_estado_civil', 

    ];

}