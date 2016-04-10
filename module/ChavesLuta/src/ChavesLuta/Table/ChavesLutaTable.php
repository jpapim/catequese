<?php

namespace ChavesLuta\Table;

use Estrutura\Table\AbstractEstruturaTable;

class ChavesLutaTable extends AbstractEstruturaTable{

    public $table = 'categoria_peso';
    public $campos = [
        'id_categoria_peso'=>'id',
        'nm_categoria_peso'=>'nm_categoria_peso'

    ];

}