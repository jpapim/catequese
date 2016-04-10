<?php

namespace Evento\Entity;

use Estrutura\Service\AbstractEstruturaService;

class EventoEntity extends AbstractEstruturaService{

        protected $id; 
        protected $id_tipo_evento;
        protected $id_cidade;
        protected $id_regra_luta;
        protected $nm_evento;
        protected $dt_evento;
        protected $vl_inscricao_colorida;
        protected $vl_inscricao_preta;
        protected $bo_inativo;



}