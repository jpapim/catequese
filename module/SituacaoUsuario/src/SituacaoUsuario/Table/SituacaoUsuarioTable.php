<?php

namespace SituacaoUsuario\Table;

use Estrutura\Table\AbstractEstruturaTable;

class SituacaoUsuarioTable extends AbstractEstruturaTable{

    public $table = 'situacao_usuario';
    public $campos = [
        'id_situacao_usuario'=>'id', 
        'nm_situacao_usuario'=>'nm_situacao_usuario', 

    ];

}