<?php

namespace SituacaoResponsavelCatequisando\Table;

use Estrutura\Table\AbstractEstruturaTable;

class SituacaoResponsavelCatequisandoTable extends AbstractEstruturaTable{

    public $table = 'situacao_responsavel_catequisando';
    public $campos = [
   
   'id_situacao_responsavel_catequisando'=>'id',        
   'id_catequisando'=>'id_catequisando',
   'id_situacao_responsavel'=>'id_situacao_responsavel',
   
];
    
    
    
}