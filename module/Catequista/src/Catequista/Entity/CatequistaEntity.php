<?php

namespace Catequista\Entity;

use Estrutura\Service\AbstractEstruturaService;

class CatequistaEntity extends AbstractEstruturaService{

        protected $id; 
        protected $id_usuario;
        protected $id_endereco;
        protected $id_sexo;
        protected $id_naturalidade;
        protected $id_telefone_residencial;
        protected $id_telefone_celular;
        protected $id_email;
        protected $id_situacao;
        protected $id_detalhe_formacao;
        protected $nm_catequista;
        protected $nr_matricula;
        protected $dt_nascimento;
        protected $dt_ingresso;
        protected $tx_observacao;
        protected $ds_situacao;
        protected $cs_coordenador;
}