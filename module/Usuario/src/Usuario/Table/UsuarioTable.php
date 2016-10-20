<?php

namespace Usuario\Table;

use Estrutura\Table\AbstractEstruturaTable;

class UsuarioTable extends AbstractEstruturaTable{

    public $table = 'usuario';
    public $campos = [
        'id_usuario'=>'id', 
        'nm_usuario'=>'nm_usuario',
        'nm_funcao'=>'nm_funcao',
        'id_sexo'=>'id_sexo',
        'id_perfil'=>'id_perfil',
        'id_situacao_usuario'=>'id_situacao_usuario', 
        'id_email'=>'id_email', 
        'id_telefone'=>'id_telefone',
    ];

}