<?php

namespace Responsavel\Table;

use Estrutura\Table\AbstractEstruturaTable;

class ResponsavelTable extends AbstractEstruturaTable{

    public $table = 'responsavel';
    public $campos = [
        'id_responsavel'=>'id', 
        'id_sexo'=>'id_sexo',
        'id_telefone_celular'=>'id_telefone_celular',
        'id_telefone_residencial'=>'id_telefone_residencial',
        'id_email'=>'id_email',
        'id_profissao'=>'id_profissao',
        'id_movimento_pastoral'=>'id_movimento_pastoral',
        'nm_responsavel'=>'nm_responsavel',
        'tx_observacao'=>'tx_observacao',
        'cs_participa_movimento_pastoral'=>'cs_participa_movimento_pastoral',
        
     
    ];

}