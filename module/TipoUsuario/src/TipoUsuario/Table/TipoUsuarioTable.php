<?php

namespace TipoUsuario\Table;

use Estrutura\Table\AbstractEstruturaTable;

class TipoUsuarioTable extends AbstractEstruturaTable{

    public $table = 'tipo_usuario';
    public $campos = [
        'id_tipo_usuario'=>'id', 
        'nm_tipo_usuario'=>'nm_tipo_usuario', 

    ];

}