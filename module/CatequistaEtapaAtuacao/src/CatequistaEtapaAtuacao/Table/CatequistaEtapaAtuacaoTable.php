<?php

namespace CatequistaEtapaAtuacao\Table;

use Estrutura\Table\AbstractEstruturaTable;

class CatequistaEtapaAtuacaoTable extends AbstractEstruturaTable{

    public $table = 'catequista_etapa_atuacao';
    public $campos = [
        'id_catequista_etapa_atuacao'=>'id', 
        'id_etapa'=>'id_etapa',
        'id_catequista'=>'id_catequista',
        'dt_cadastro'=>'dt_cadastro',
    ];

}