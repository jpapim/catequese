<?php

namespace Usuario\Entity;

use Estrutura\Service\AbstractEstruturaService;

class UsuarioEntity extends AbstractEstruturaService{

        protected $id; 
        protected $nm_usuario; 
        protected $dt_nascimento; 
        protected $nu_rg; 
        protected $nu_cpf; 
        protected $nm_profissao; 
        protected $nm_nacionalidade; 
        protected $id_sexo; 
        protected $id_estado_civil; 
        protected $id_tipo_usuario; 
        protected $id_situacao_usuario; 
        protected $id_email; 
        protected $id_telefone; 
        protected $id_endereco; 
}