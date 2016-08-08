<?php

namespace CatequistaTurma\Table;

use Estrutura\Table\AbstractEstruturaTable;

class CatequistaTurmaTable extends AbstractEstruturaTable{

    public $table = 'catequista_turma';
    public $campos = [
        'id_catequista_turma'=>'id', 
        'id_turma'=>'id_turma',
        'id_catequista'=>'id_catequista',
     
    ];

}