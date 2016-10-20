<?php

namespace Usuario\Entity;

use Estrutura\Service\AbstractEstruturaService;

class UsuarioEntity extends AbstractEstruturaService
{

    protected $id;
    protected $nm_usuario;
    protected $nm_funcao;
    protected $id_sexo;
    protected $id_perfil;
    protected $id_situacao_usuario;
    protected $id_email;
    protected $id_telefone;
}