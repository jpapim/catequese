<?php

namespace Turno\Table;

use Estrutura\Table\AbstractEstruturaTable;

class TurnoTable extends AbstractEstruturaTable{

    public $table = 'turno';
    public $campos = [
        'id_turno'=>'id',
        'nm_turno'=>'nm_turno',
     
    ];

}