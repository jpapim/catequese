<?php

namespace GrauParentesco\Table;

use Estrutura\Table\AbstractEstruturaTable;

class GrauParentescoTable extends AbstractEstruturaTable{

    public $table = 'grau_parentesco';
    public $campos = [
        'id_grau_parentesco'=>'id', 
        'nm_grau_parentesco'=>'nm_grau_parentesco',
     
    ];

}