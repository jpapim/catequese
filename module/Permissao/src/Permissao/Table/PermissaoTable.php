<?php

namespace Permissao\Table;

use Estrutura\Table\AbstractEstruturaTable;

class PermissaoTable extends AbstractEstruturaTable{

    public $table = 'perfil_controller_action';
    public $campos = [
        'id_perfil_controller_action'=>'id',
        'id_controller'=>'id_controller',
        'id_action'=>'id_action',
        'id_perfil'=>'id_perfil',

    ];

}