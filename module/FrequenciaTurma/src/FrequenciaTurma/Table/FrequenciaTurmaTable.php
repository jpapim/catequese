<?php

namespace FrequenciaTurma\Table;

use Estrutura\Table\AbstractEstruturaTable;

class FrequenciaTurmaTable extends AbstractEstruturaTable
{
    public $table = 'frequencia_turma';
    public $campos = [
        'id_frequencia_turma'=>'id',
        'id_turma_catequisando'=>'id_turma_catequisando',
        'id_detalhe_periodo_letivo'=>'id_detalhe_periodo_letivo',

    ];
}