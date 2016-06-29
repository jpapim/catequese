<?php

namespace Turma\Table;

use Estrutura\Table\AbstractEstruturaTable;

class TurmaTable extends AbstractEstruturaTable{

    public $table = 'turma';
    public $campos = [
        'id_turma'=>'id', 
        'id_etapa'=>'id_etapa',
        'cd_turma'=>'cd_turma', 
        'nm_turma'=>'nm_turma',
       
        

    ];

}