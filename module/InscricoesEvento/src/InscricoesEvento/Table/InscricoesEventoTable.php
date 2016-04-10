<?php

namespace InscricoesEvento\Table;

use Estrutura\Table\AbstractEstruturaTable;

class InscricoesEventoTable extends AbstractEstruturaTable{

    public $table = 'inscricoes_evento';
    public $campos = [
        'id_inscricao_evento'=>'id',
        'id_evento'=>'id_evento',
        'id_atleta'=>'id_atleta',
        'dt_inscricao'=>'dt_inscricao'

    ];

}