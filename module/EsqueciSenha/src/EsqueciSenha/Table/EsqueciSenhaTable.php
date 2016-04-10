<?php

namespace EsqueciSenha\Table;

use Estrutura\Table\AbstractEstruturaTable;

class EsqueciSenhaTable extends AbstractEstruturaTable {

    public $table = 'esqueci_senha';
    public $campos = [
        'id_esqueci_senha' => 'id',
        'id_usuario' => 'id_usuario',
        'tx_identificacao' => 'tx_identificacao',
        'id_situacao' => 'id_situacao',
        'dt_solicitacao' => 'dt_solicitacao',
        'dt_alteracao' => 'dt_alteracao',
    ];

}
