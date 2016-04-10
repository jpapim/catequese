<?php

namespace Evento\Table;

use Estrutura\Table\AbstractEstruturaTable;

class EventoTable extends AbstractEstruturaTable{

    public $table = 'eventos';
    public $campos = [
        'id_evento'=>'id',
        'id_tipo_evento'=>'id_tipo_evento',
        'id_cidade'=>'id_cidade',
        'id_regra_luta'=>'id_regra_luta',
        'nm_evento'=>'nm_evento',
        'dt_evento'=>'dt_evento',
        'vl_inscricao_colorida'=>'vl_inscricao_colorida',
        'vl_inscricao_preta'=>'vl_inscricao_preta',
        'bo_inativo'=>'bo_inativo'
    ];

}