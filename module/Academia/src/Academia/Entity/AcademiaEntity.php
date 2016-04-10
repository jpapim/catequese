<?php

namespace Academia\Entity;

use Estrutura\Service\AbstractEstruturaService;

class AcademiaEntity extends AbstractEstruturaService{

        protected $id; 
        protected $nm_academia;
        protected $id_cidade;
        protected $id_usuario_cadastro;
        protected $id_usuario;
        protected $id_arte_marcial;
        protected $tx_endereco;
        protected $tx_complemento;
        protected $dt_cadastro;
        protected $nr_cep;
        protected $bo_excluido;

}