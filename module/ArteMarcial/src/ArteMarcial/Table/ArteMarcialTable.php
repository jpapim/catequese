<?php

namespace ArteMarcial\Table;

use Estrutura\Table\AbstractEstruturaTable;

class ArteMarcialTable extends AbstractEstruturaTable{

    public $table = 'arte_marcial';
    public $campos = [
        'id_arte_marcial'=>'id',
        'nm_arte_marcial'=>'nm_arte_marcial',
    ];

}