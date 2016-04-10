<?php
namespace Auth\Entity;

use Estrutura\Service\AbstractEstruturaService;

class AuthEntity extends AbstractEstruturaService{

    protected $id_usuario;
    protected $id_perfil;
    protected $em_email;        
    protected $pw_senha;
    protected $nm_usuario;    
    protected $id_contrato;    
} 