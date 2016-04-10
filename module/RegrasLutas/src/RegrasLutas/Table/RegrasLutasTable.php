<?php

namespace RegrasLutas\Table;

use Estrutura\Table\AbstractEstruturaTable;

class RegrasLutasTable extends AbstractEstruturaTable{

    public $table = 'regras_lutas';
    public $campos = [
        'id_regra_luta'=>'id',
        'nm_regra_luta'=>'nm_regra_luta'

    ];

}