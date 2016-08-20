<?php

namespace Responsavel\Entity;

use Estrutura\Service\AbstractEstruturaService;

class ResponsavelEntity extends AbstractEstruturaService{

        protected $id; 
        protected $id_sexo;
        protected $id_telefone_celular;
        protected $id_telefone_residencial;
        protected $id_email;
        protected $id_profissao;
        protected $id_movimento_pastoral;
        protected $nm_responsavel;
        protected $tx_observacao;
        protected $cs_participa_movimento_pastoral;

}