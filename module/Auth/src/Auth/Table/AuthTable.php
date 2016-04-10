<?php

namespace Auth\Table;

use Estrutura\Table\AbstractEstruturaTable;

class AuthTable extends AbstractEstruturaTable{

    public $table = 'auth';
    public $campos = [
        'id_usuario' => 'id_usuario',
        'id_perfil' => 'id_perfil',
        'em_email' => 'em_email',
        'pw_senha' => 'pw_senha',
        'nm_usuario' => 'nm_usuario',
        'id_contrato' => 'id_contrato',
    ];
}