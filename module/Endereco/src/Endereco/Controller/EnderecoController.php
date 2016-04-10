<?php

namespace Endereco\Controller;

use Estrutura\Controller\AbstractCrudController;

class EnderecoController extends AbstractCrudController
{
    /**
     * @var \Endereco\Service\Endereco
     */
    protected $service;

    /**
     * @var \Endereco\Form\Endereco
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
