<?php

namespace Sexo\Controller;

use Estrutura\Controller\AbstractCrudController;

class SexoController extends AbstractCrudController
{
    /**
     * @var \Sexo\Service\Sexo
     */
    protected $service;

    /**
     * @var \Sexo\Form\Sexo
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
