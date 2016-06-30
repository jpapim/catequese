<?php

namespace Catequista\Table;

use Estrutura\Table\AbstractEstruturaTable;

class CatequistaTable extends AbstractEstruturaTable{

    public $table = 'catequista';
    public $campos = [
   
   'id_catequista'=>'id',        
   'id_usuario'=>'id_usuario',
   'id_endereco'=>'id_endereco',
   'id_sexo'=>'id_sexo',
   'id_naturalidade'=>'id_naturalidade',
   'id_telefone_residencial'=>'id_telefone_residencial',
   'id_telefone_celular'=>'id_telefone_celular',
   'id_email'=>'id_email',
   'id_situacao'=>'id_situacao',
   'id_detalhe_formacao'=>'id_detalhe_formacao',
   'nm_catequista'=>'nm_catequista',
   'nr_matricula'=>'nr_matricula',
   'dt_nascimento'=>'dt_nascimento',
   'dt_ingresso'=>'dt_ingresso',
   'tx_observacao'=>'tx_observacao',
   'ds_situacao'=>'ds_situacao',
   'cs_coordenador'=>'cs_coordenador',
        
              
];
    
    
    
}