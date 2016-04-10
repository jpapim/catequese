<?php

namespace Login\Entity;

use Estrutura\Service\AbstractEstruturaService;

class LoginEntity extends AbstractEstruturaService{

        protected $id; 
        protected $pw_senha; 
        protected $nr_tentativas; 
        protected $dt_visita; 
        protected $dt_registro; 
        protected $id_usuario; 
        protected $id_email; 
        protected $id_situacao; 
        protected $id_perfil; 



}