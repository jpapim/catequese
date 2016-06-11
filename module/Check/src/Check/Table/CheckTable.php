<?php

namespace Check\Table;

use Estrutura\Table\AbstractEstruturaTable;

class CheckTable extends AbstractEstruturaTable{

    public $table = 'estado';
    public $campos = [
        'id_estado'=>'id',
        'nm_estado'=>'nm_estado',
        'sg_estado'=>'sg_estado'

    ];

}