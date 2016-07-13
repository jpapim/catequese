<?php


namespace Profissao\Table;

use Estrutura\Table\AbstractEstruturaTable;

class ProfissaoTable extends  AbstractEstruturaTable {

    public $table = "profissao";
    public  $campos= [
        'id_profissao'=>'id',
        'nm_profissao'=>'nm_profissao'
    ];

} 