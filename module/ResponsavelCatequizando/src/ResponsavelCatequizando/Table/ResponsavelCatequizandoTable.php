<?php

namespace ResponsavelCatequizando\Table;

use Estrutura\Table\AbstractEstruturaTable;

class ResponsavelCatequizandoTable extends AbstractEstruturaTable{

    public $table = 'responsavel_catequizando';
    public $campos = [
        'id_responsavel_catequizando'=>'id',
        'id_catequizando'=>'id_catequizando',
        'id_responsavel'=>'id_responsavel',
        'id_grau_parentesco'=>'id_grau_parentesco',
        'id_situacao_conjugal'=>'id_situacao_conjugal',
    ];

}