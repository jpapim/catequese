<?php

namespace Login\Table;

use Estrutura\Table\AbstractEstruturaTable;

class LoginTable extends AbstractEstruturaTable{

    public $table = 'login';
    public $campos = [
        'id_Login'=>'id', 
        'pw_senha'=>'pw_senha', 
        'nr_tentativas'=>'nr_tentativas', 
        'dt_visita'=>'dt_visita', 
        'dt_registro'=>'dt_registro', 
        'id_usuario'=>'id_usuario', 
        'id_email'=>'id_email', 
        'id_situacao'=>'id_situacao', 
        'id_perfil'=>'id_perfil', 

    ];

}