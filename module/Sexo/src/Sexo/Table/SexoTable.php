<?php

namespace Sexo\Table;

use Estrutura\Table\AbstractEstruturaTable;

class SexoTable extends AbstractEstruturaTable{

    public $table = 'sexo';
    public $campos = [
        'id_sexo'=>'id', 
        'nm_sexo'=>'nm_sexo', 

    ];

}