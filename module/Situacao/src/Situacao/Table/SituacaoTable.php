<?php

namespace Situacao\Table;

use Estrutura\Table\AbstractEstruturaTable;

class SituacaoTable extends AbstractEstruturaTable{

    public $table = 'situacao';
    public $campos = [
        'id_situacao'=>'id', 
        'nm_situacao'=>'nm_situacao', 

    ];

}