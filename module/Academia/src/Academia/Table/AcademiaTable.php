<?php

namespace Academia\Table;

use Estrutura\Table\AbstractEstruturaTable;

class AcademiaTable extends AbstractEstruturaTable{

    public $table = 'academias';
    public $campos = [
        'id_academia'=>'id',
        'nm_academia'=>'nm_academia',
        'id_cidade'=>'id_cidade',
        'id_usuario_cadastro'=>'id_usuario_cadastro',
        'id_usuario'=>'id_usuario',
        'id_arte_marcial'=>'id_arte_marcial',
        'tx_endereco'=>'tx_endereco',
        'tx_complemento'=>'tx_complemento',
        'dt_cadastro'=>'dt_cadastro',
        'nr_cep'=>'nr_cep',
        'bo_excluido'=>'bo_excluido',
    ];

}