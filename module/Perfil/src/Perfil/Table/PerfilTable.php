<?php

namespace Perfil\Table;

use Estrutura\Table\AbstractEstruturaTable;

class PerfilTable extends AbstractEstruturaTable{

    public $table = 'perfil';
    public $campos = [
        'id_perfil'=>'id', 
        'nm_perfil'=>'nm_perfil', 

    ];

}