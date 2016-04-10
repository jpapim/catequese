<?php

namespace DetalhesRegrasLuta\Table;

use Estrutura\Table\AbstractEstruturaTable;

class DetalhesRegrasLutaTable extends AbstractEstruturaTable{

    public $table = 'detalhes_regras_luta';
    public $campos = [
        'id_detalhe_regra_luta'=>'id',
        'id_regra_luta'=>'id_regra_luta',
        'id_categoria_idade'=>'id_categoria_idade',
        'id_categoria_peso'=>'id_categoria_peso',
        'id_usuario_cadastro'=>'id_usuario_cadastro',
        'id_graduacao_inicial'=>'id_graduacao_inicial',
        'id_graduacao_final'=>'id_graduacao_final',
        'nr_idade_inicial'=>'nr_idade_inicial',
        'nr_idade_final'=>'nr_idade_final',
        'nr_peso_inicial'=>'nr_peso_inicial',
        'nr_peso_final'=>'nr_peso_final',
        'id_sexo'=>'id_sexo'
    ];

}