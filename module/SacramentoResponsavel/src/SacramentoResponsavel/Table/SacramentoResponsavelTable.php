<?php

namespace SacramentoResponsavel\Table;

use Estrutura\Table\AbstractEstruturaTable;

class SacramentoResponsavelTable extends AbstractEstruturaTable{

    public $table = 'sacramento_responsavel';
    public $campos = [
   
   'id_sacramento_responsavel'=>'id',        
   'id_sacramento'=>'id_sacramento',
   'id_responsavel'=>'id_responsavel',
   
];
    
    
    
}