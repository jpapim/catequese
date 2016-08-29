<?php

namespace SituacaoResponsavelCatequizando\Table;

use Estrutura\Table\AbstractEstruturaTable;

class SituacaoResponsavelCatequizandoTable extends AbstractEstruturaTable{

    public $table = 'situacao_responsavel_catequizando';
    public $campos = [
   
   'id_situacao_responsavel_catequizando'=>'id',
   'id_catequizando'=>'id_catequizando',
   'id_situacao_responsavel'=>'id_situacao_responsavel',
   
];
    
    
    
}