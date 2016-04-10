<?php

namespace CategoriaPeso\Table;

use Estrutura\Table\AbstractEstruturaTable;

class CategoriaPesoTable extends AbstractEstruturaTable{

    public $table = 'categoria_peso';
    public $campos = [
        'id_categoria_peso'=>'id',
        'nm_categoria_peso'=>'nm_categoria_peso'

    ];

}