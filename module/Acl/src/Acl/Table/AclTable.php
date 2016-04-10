<?php

namespace Acl\Table;

use Estrutura\Table\AbstractEstruturaTable;

class AclTable extends AbstractEstruturaTable{

    public $table = 'acl';
    public $campos = [
        'id_perfil'=>'id_perfil', 
        'nm_resource'=>'nm_resource', 

    ];

}