<?php

namespace CatequizandoEtapaCursou\Table;

use Estrutura\Table\AbstractEstruturaTable;

class CatequizandoEtapaCursouTable extends AbstractEstruturaTable{

    public $table = 'catequizando_etapa_cursou';
    public $campos = [
        'id_catequizando_etapa_cursou'=>'id',
        'id_etapa'=>'id_etapa',
        'id_catequizando'=>'id_catequizando',
        'dt_cadastro'=>'dt_cadastro',
    ];

}