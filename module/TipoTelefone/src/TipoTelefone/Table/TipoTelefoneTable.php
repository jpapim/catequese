<?php

namespace TipoTelefone\Table;

use Estrutura\Table\AbstractEstruturaTable;

class TipoTelefoneTable extends AbstractEstruturaTable{

    public $table = 'tipo_telefone';
    public $campos = [
        'id_tipo_telefone'=>'id', 
        'nm_tipo_telefone'=>'nm_tipo_telefone', 

    ];

}