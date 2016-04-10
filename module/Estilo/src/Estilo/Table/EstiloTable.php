<?php

namespace Estilo\Table;

use Estrutura\Table\AbstractEstruturaTable;

class EstiloTable extends AbstractEstruturaTable{

    public $table = 'estilos';
    public $campos = [
        'id_estilo'=>'id',
        'nm_estilo'=>'nm_estilo',
        'ds_estilo'=>'ds_estilo',
    ];

}