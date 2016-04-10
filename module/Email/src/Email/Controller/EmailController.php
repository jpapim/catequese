<?php

namespace Email\Controller;

use Estrutura\Controller\AbstractCrudController;

class EmailController extends AbstractCrudController
{
    /**
     * @var \Email\Service\Email
     */
    protected $service;

    /**
     * @var \Email\Form\Email
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
