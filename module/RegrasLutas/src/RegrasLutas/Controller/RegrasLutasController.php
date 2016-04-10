<?php

namespace RegrasLutas\Controller;

use Estrutura\Controller\AbstractCrudController;

class RegrasLutasController extends AbstractCrudController
{
    /**
     * @var \RegrasLutas\Service\RegrasLutas
     */
    protected $service;

    /**
     * @var \RegrasLutas\Form\RegrasLutas
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
        #Alysson
        $controller = $this->params('controller');
        $this->addSuccessMessage('Registro Alterado com sucesso');
        $this->redirect()->toRoute('navegacao', array('controller' => $controller, 'action' => 'index'));
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
