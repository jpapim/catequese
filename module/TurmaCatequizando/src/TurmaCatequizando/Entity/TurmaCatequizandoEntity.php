<?php

namespace TurmaCatequizando\Entity;

use Estrutura\Service\AbstractEstruturaService;

class TurmaCatequizandoEntity extends AbstractEstruturaService{

        protected $id; 
        protected $id_turma;
        protected $id_catequizando;
        protected $id_usuario;
        protected $id_periodo_letivo; 
        protected $dt_cadastro;
        protected $cs_aprovado; 
        protected $ds_motivo_reprovacao;
        protected $tx_observacoes;
        protected $nr_sala;

}