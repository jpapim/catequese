<?php

namespace Usuario\Entity;

use Estrutura\Service\AbstractEstruturaService;

class UsuarioEntity extends AbstractEstruturaService{

        protected $id; 
        protected $nm_usuario; 
        protected $dt_nascimento;
        protected $id_tipo_usuario; 
        protected $id_situacao_usuario; 
        protected $id_email;
}