<?php

namespace EsqueciSenha\Controller;

use Estrutura\Controller\AbstractCrudController;

class EsqueciSenhaController extends AbstractCrudController
{
    /**
     * @var \Perfil\Service\Perfil
     */
    protected $service;

    /**
     * @var \Perfil\Form\Perfil
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
