<?php

namespace Auth\Table;

use Estrutura\Table\AbstractEstruturaTable;

class AclTable extends AbstractEstruturaTable{

    public $table = 'acl';
    public $campos = [
        'nm_resource' => 'nm_resource',
        'id_perfil' => 'id_perfil'
    ];
}