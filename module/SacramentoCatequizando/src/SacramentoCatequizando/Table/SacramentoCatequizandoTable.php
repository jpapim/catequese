<?php

namespace SacramentoCatequizando\Table;

use Estrutura\Table\AbstractEstruturaTable;

class SacramentoCatequizandoTable extends AbstractEstruturaTable
{
    public $table = 'sacramento_catequizando';
    public $campos = [
        'id_sacramento_catequizando'=>'id',
        'id_catequizando'=>'id_catequizando',
        'id_sacramento'=>'id_sacramento',
        'dt_cadastro'=>'dt_cadastro',
        'id_paroquia'=>'id_paroquia',
        'cs_comprovante_batismo'=>'cs_comprovante_batismo',

    ];
}