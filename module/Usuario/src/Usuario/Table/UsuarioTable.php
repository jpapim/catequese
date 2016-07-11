<?php

namespace Usuario\Table;

use Estrutura\Table\AbstractEstruturaTable;

class UsuarioTable extends AbstractEstruturaTable{

    public $table = 'usuario';
    public $campos = [
        'id_usuario'=>'id', 
        'nm_usuario'=>'nm_usuario', 
        'dt_nascimento'=>'dt_nascimento',
        'id_tipo_usuario'=>'id_tipo_usuario', 
        'id_situacao_usuario'=>'id_situacao_usuario', 
        'id_email'=>'id_email',

    ];

}