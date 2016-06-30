<?php

namespace Catequista\Controller;

use Estrutura\Controller\AbstractCrudController;
use Estrutura\Helpers\Cript;
use Estrutura\Helpers\Data;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

class CatequistaController extends AbstractCrudController
{
   
    protected $service;

    
    protected $form;

     public function __construct(){
        parent::init();
     }

 
      public function indexAction()
             {
 return parent::index($this->service, $this->form);        
//http://igorrocha.com.br/tutorial-zf2-parte-9-paginacao-busca-e-listagem/4/
      
    
        return new ViewModel([
            'service' => $this->service,
            'form' => $this->form,
            'controller' => $this->params('controller'),
            'atributos' => array()
        ]);
    }
    
    public function gravarAction(){
        
        // $resultSexo = parent::gravar(
                        //    $this->getServiceLocator()->get('\Sexo\Service\SexoService'), new \Sexo\Form\SexoForm()
           // );
        
        //verificando email
        $emailService = $this->getServiceLocator()->get('\Email\Service\EmailService');
        $emailService->setEmEmail(trim($this->getRequest()->getPost()->get('em_email')));

        if ($emailService->filtrarObjeto()->count()) {

            $this->addErrorMessage('Email já cadastrado. Faça seu login.');
            $this->redirect()->toRoute('cadastro', array('id' => $this->getRequest()->getPost()->get('id_usuario_pai')));
            return FALSE;
        }
//gravando email
          $resultEmail = parent::gravar(
                            $this->getServiceLocator()->get('\Email\Service\EmailService'), new \Email\Form\EmailForm()
            );
        
if($resultEmail){
        $this->addSuccessMessage('Registro Inserido/Alterado com sucesso');
        
        $this->redirect()->toRoute('navegacao', array('controller' => 'catequista-catequista', 'action' => 'index'));
        return parent::gravar($this->service, $this->form);
        
     
    }}

  public function cadastroAction()
    { // funnção alterar
        return parent::cadastro($this->service, $this->form);
    }
    public function excluirAction()
    {
        return parent::excluir($this->service, $this->form);
}}