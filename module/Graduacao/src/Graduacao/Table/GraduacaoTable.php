<?php

namespace Graduacao\Table;

use Estrutura\Table\AbstractEstruturaTable;

class GraduacaoTable extends AbstractEstruturaTable{

    public $table = 'graduacoes';
    public $campos = [
        'id_graduacao'=>'id',
        'id_estilo'=>'id_estilo',
        'id_arte_marcial'=>'id_arte_marcial',
        'nm_graduacao'=>'nm_graduacao',
        'sg_graduacao'=>'sg_graduacao',
    ];

}