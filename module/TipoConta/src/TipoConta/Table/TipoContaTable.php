<?php

namespace TipoConta\Table;

use Estrutura\Table\AbstractEstruturaTable;

class TipoContaTable extends AbstractEstruturaTable{

    public $table = 'tipo_conta';
    public $campos = [
        'id_tipo_conta'=>'id', 
        'nm_tipo_conta'=>'nm_tipo_conta', 

    ];

}