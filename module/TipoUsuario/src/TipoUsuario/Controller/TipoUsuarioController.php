<?php

namespace TipoUsuario\Controller;

use Estrutura\Controller\AbstractCrudController;

class TipoUsuarioController extends AbstractCrudController
{
    /**
     * @var \TipoUsuario\Service\TipoUsuario
     */
    protected $service;

    /**
     * @var \TipoUsuario\Form\TipoUsuario
     */
    protected $form;

    public function __construct(){
        parent::init();
    }

    public function indexAction()
    {
        return parent::index($this->service, $this->form);
    }

    public function gravarAction(){
        return parent::gravar($this->service, $this->form);
    }

    public function cadastroAction()
    {
        return parent::cadastro($this->service, $this->form);
    }

    public function excluirAction()
    {
        return parent::excluir($this->service, $this->form);
    }
}
