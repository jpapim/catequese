<?php

namespace CategoriaIdade\Table;

use Estrutura\Table\AbstractEstruturaTable;

class CategoriaIdadeTable extends AbstractEstruturaTable{

    public $table = 'categoria_idade';
    public $campos = [
        'id_categoria_idade'=>'id',
        'nm_categoria_idade'=>'nm_categoria_idade',
        'nr_sugestao_idade_inicial'=>'nr_sugestao_idade_inicial',
        'nr_sugestao_idade_final'=>'nr_sugestao_idade_final',
    ];

}