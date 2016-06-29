<?php

namespace TurmaCatequisando\Entity;

use Estrutura\Service\AbstractEstruturaService;

class TurmaCatequisandoEntity extends AbstractEstruturaService{

        protected $id; 
        protected $id_turma;
        protected $id_catequisando; 
        protected $id_usuario;
        protected $id_periodo_letivo; 
        protected $dt_cadastro;
        protected $cs_aprovado; 
        protected $ds_motivo_reprovacao;
        protected $tx_observacoes; 

}