<?php

namespace TipoEvento\Table;

use Estrutura\Table\AbstractEstruturaTable;

class TipoEventoTable extends AbstractEstruturaTable{

    public $table = 'tipos_eventos';
    public $campos = [
        'id_tipo_evento'=>'id',
        'nm_tipo_evento'=>'nm_tipo_evento',
        'ds_tipo_evento'=>'ds_tipo_evento',

    ];

}