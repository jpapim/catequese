<?php

namespace TurmaCatequisando\Table;

use Estrutura\Table\AbstractEstruturaTable;

class TurmaCatequisandoTable extends AbstractEstruturaTable{

    public $table = 'turma_catequisando';
    public $campos = [
        'id_turma_catequisando'=>'id', 
        'id_turma'=>'id_turma',
        'id_catequisando'=>'id_catequisando',
        'id_usuario'=>'id_usuario',
        'id_periodo_letivo'=>'id_periodo_letivo',
        'dt_cadastro'=>'dt_cadastro',
        'cs_aprovado'=>'cs_aprovado',
        'ds_motivo_reprovacao'=>'ds_motivo_reprovacao',
        'tx_observacoes'=>'tx_observacoes',
    ];

}