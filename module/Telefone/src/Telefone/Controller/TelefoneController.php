<?php

namespace Telefone\Controller;

use Estrutura\Controller\AbstractCrudController;

class TelefoneController extends AbstractCrudController
{
    /**
     * @var \Telefone\Service\Telefone
     */
    protected $service;

    /**
     * @var \Telefone\Form\Telefone
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
