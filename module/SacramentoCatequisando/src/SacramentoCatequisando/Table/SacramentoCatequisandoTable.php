<?php

namespace SacramentoCatequisando\Table;

use Estrutura\Table\AbstractEstruturaTable;

class SacramentoCatequisandoTable extends AbstractEstruturaTable
{
    public $table = 'sacramento_catequisando';
    public $campos = [
        'id_sacramento_catequisando'=>'id',
        'id_catequisando'=>'id_catequisando',
        'id_sacramento'=>'id_sacramento',
        'dt_cadastro'=>'dt_cadastro',
        'id_paroquia'=>'id_paroquia',
        'cs_comprovante_batismo'=>'cs_comprovante_batismo',

    ];
}