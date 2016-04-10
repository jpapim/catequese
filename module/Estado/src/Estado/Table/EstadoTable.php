<?php

namespace Estado\Table;

use Estrutura\Table\AbstractEstruturaTable;

class EstadoTable extends AbstractEstruturaTable{

    public $table = 'estado';
    public $campos = [
        'id_estado'=>'id', 
        'nm_estado'=>'nm_estado', 
        'sg_estado'=>'sg_estado'

    ];

}