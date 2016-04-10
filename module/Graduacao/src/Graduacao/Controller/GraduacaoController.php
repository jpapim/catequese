<?php

namespace Graduacao\Controller;

use Estrutura\Controller\AbstractCrudController;

use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\ArrayAdapter;
use Zend\View\Model\ViewModel;

class GraduacaoController extends AbstractCrudController
{
    /**
     * @var \Graduacao\Service\Graduacao
     */
    protected $service;

    /**
     * @var \Graduacao\Form\Graduacao
     */
    protected $form;

    public function __construct(){
        parent::init();
    }

    public function indexAction()
    {
        $dadosView = [
            'service' => $this->service,
            'form' => $this->form,
            'lista' => $this->service->filtrarObjeto(),
            'controller' => $this->params('controller'),
            'atributos' => array()
        ];
        return new ViewModel($dadosView);
        //return parent::index($this->service, $this->form);
    }

    public function gravarAction() {
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

    public function xxxAction()
    {
        $dadosView = array(
                            'abc'=>'wwwwwwwwwwwwwwwwwwwwwwwwwwwwww',
                            'def'=>'qqqqqqqqqqqqqqqqqqqqqqqqqqqqqq'
        );
        return new ViewModel($dadosView);
    }
}
