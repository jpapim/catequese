<?php

namespace TurmaCatequizando\Table;

use Estrutura\Table\AbstractEstruturaTable;

class TurmaCatequizandoTable extends AbstractEstruturaTable{

    public $table = 'turma_catequizando';
    public $campos = [
        'id_turma_catequizando'=>'id',
        'id_turma'=>'id_turma',
        'id_catequizando'=>'id_catequizando',
        'id_usuario'=>'id_usuario',
        'id_periodo_letivo'=>'id_periodo_letivo',
        'dt_cadastro'=>'dt_cadastro',
        'cs_aprovado'=>'cs_aprovado',
        'ds_motivo_reprovacao'=>'ds_motivo_reprovacao',
        'tx_observacoes'=>'tx_observacoes',
    ];

}