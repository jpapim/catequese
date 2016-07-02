<?php

namespace Etapa\Table;

use Estrutura\Table\AbstractEstruturaTable;

class EtapaTable extends AbstractEstruturaTable{

    public $table = 'etapa';
    public $campos = [
        'id_etapa'=>'id', 
        'nm_etapa'=>'nm_etapa', 
        

    ];

}