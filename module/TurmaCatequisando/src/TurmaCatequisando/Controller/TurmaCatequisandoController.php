<?php

namespace TurmaCatequisando\Controller;

use Estrutura\Controller\AbstractCrudController;
use Estrutura\Helpers\Cript;
use Estrutura\Helpers\Data;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

class TurmaCatequisandoController extends AbstractCrudController
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

        // FORMATANDO AS DATAS RECEBIDAS     
$dateCadastro = \DateTime::createFromFormat('d/m/Y', $this->getRequest()->getPost()->get('dt_cadastro'));

        //GRAVANDO 

  // INSERINDO CAMPOS COM FKS NA TABELA TURMA 
        $turmaCatequisandoService = $this->getServiceLocator()->get('\TurmaCatequisando\Service\TurmaCatequisandoService');
        $turmaCatequisandoService->setIdTurma(trim($this->getRequest()->getPost()->get('id_turma')));
       // $turmaCatequisandoService->setIdCatequisando(trim($this->getRequest()->getPost()->get('id_catequisando')));
        $turmaCatequisandoService->setIdUsuario(trim($this->getRequest()->getPost()->get('id_usuario')));
        $turmaCatequisandoService->setIdPeriodoLetivo(trim($this->getRequest()->getPost()->get('id_periodo_letivo')));
        
        ///INSERINDO CAMPOS DA TABELA TURMA
        $turmaCatequisandoService->setCdTurma(trim($this->getRequest()->getPost()->get($dateCadastro)));
        $turmaCatequisandoService->setNmTurma(trim($this->getRequest()->getPost()->get('cs_aprovado')));
        $turmaCatequisandoService->setNmTurma(trim($this->getRequest()->getPost()->get('ds_motivo_reprovacao')));
        $turmaCatequisandoService->setNmTurma(trim($this->getRequest()->getPost()->get('tx_observacoes')));
      
        parent::gravar(
                            $this->getServiceLocator()->get('\TurmaCatequisando\Service\TurmaCatequisandoService'), new \TurmaCatequisando\Form\TurmaCatequisandoForm()
            );
    
    $this->addSuccessMessage('Registro Inserido/Alterado com sucesso');
    $this->redirect()->toRoute('navegacao', array('controller' => 'turma_catequisando-turmacatequisando', 'action' => 'index'));
        
   
    }
 
  public function cadastroAction()
    { 
        return parent::cadastro($this->service, $this->form);
    }
    public function excluirAction()
    {
        return parent::excluir($this->service, $this->form);
}}