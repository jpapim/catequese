<?php

namespace CatequisandoEtapaCursou\Table;

use Estrutura\Table\AbstractEstruturaTable;

class CatequisandoEtapaCursouTable extends AbstractEstruturaTable{

    public $table = 'catequisando_etapa_cursou';
    public $campos = [
        'id_catequisando_etapa_cursou'=>'id', 
        'id_etapa'=>'id_etapa',
        'id_catequisando'=>'id_catequisando',
        'dt_cadastro'=>'dt_cadastro',
    ];

}