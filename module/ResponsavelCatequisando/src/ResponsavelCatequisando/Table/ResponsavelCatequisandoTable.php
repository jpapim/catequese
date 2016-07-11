<?php

namespace ResponsavelCatequisando\Table;

use Estrutura\Table\AbstractEstruturaTable;

class ResponsavelCatequisandoTable extends AbstractEstruturaTable{

    public $table = 'responsavel_catequisando';
    public $campos = [
        'id_responsavel_catequisando'=>'id', 
        'id_responsavel'=>'id_responsavel',
        'id_catequisando'=>'id_catequisando',
        'id_grau_parentesco'=>'id_grau_parentesco',    
    ];

}