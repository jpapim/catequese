<?php

namespace Responsavel\Controller;

use Estrutura\Controller\AbstractCrudController;
use Estrutura\Helpers\Cript;
use Estrutura\Helpers\Data;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

class ResponsavelController extends AbstractCrudController
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
$dateNascimento = \DateTime::createFromFormat('d/m/Y', $this->getRequest()->getPost()->get('dt_nascimento'));
$dateIngresso = \DateTime::createFromFormat('d/m/Y', $this->getRequest()->getPost()->get('dt_ingresso'));


###########################- GRAVANDO EMAIL -#######################################################################
 
      //##############################################################################################
        //GRAVANDO TABELA EMAIL
 $form = new \Responsavel\Form\ResponsavelForm();
        /* @var $emailService \Email\Service\EmailService */
        $emailService = $this->getServiceLocator()->get('\Email\Service\EmailService');
        $emailService->setEmEmail(trim($this->getRequest()->getPost()->get('em_email')));
        $emailService->setEmEmail(trim($this->getRequest()->getPost()->get('id_situacao')));
        #Alysson - Verifica se já existe este emaill cadastrado para um usuário
        if ($emailService->filtrarObjeto()->count()) {
            $this->addErrorMessage('Email já cadastrado. Faça seu login.');
           
            return FALSE;
        }
           $resultEmail = parent::gravar(
                $this->getServiceLocator()->get('\Email\Service\EmailService'), new \Email\Form\EmailForm()
            );


if($resultEmail){
 
  // INSERINDO CAMPOS COM FKS DA TABELA RESPONSAVEL
       $this->getRequest()->getPost()->set('id_sexo', $this->getRequest()->getPost()->get('id_sexo'));
      
        $this->getRequest()->getPost()->set('id_email', $resultEmail);
       
        $this->getRequest()->getPost()->set('id_email', $resultEmail);
        
        $this->getRequest()->getPost()->set('id_movimento_pastoral', $this->getRequest()->getPost()->get('id_movimento_pastoral'));
        
        ///INSERINDO CAMPOS DA TABELA RESPONSAVEL
        $this->getRequest()->getPost()->set('nm_responsavel', $this->getRequest()->getPost()->get('nm_responsavel'));
        $this->getRequest()->getPost()->set('tx_observacao', $this->getRequest()->getPost()->get('tx_observacao'));
 
        
        $this->getRequest()->getPost()->set('cs_participa_movimento_pastoral', $this->getRequest()->getPost()->get('cs_participa_movimento_pastoral'));
        
        
           parent::gravar(
                            $this->getServiceLocator()->get('\Responsavel\Service\ResponsavelService'), new \Responsavel\Form\ResponsavelDetalheForm()
            );
    
    $this->addSuccessMessage('Registro Inserido/Alterado com sucesso');
    $this->redirect()->toRoute('navegacao', array('controller' => 'responsavel-responsavel', 'action' => 'index'));
        
   
    }}

  public function cadastroAction()
    { // funnção alterar
        return parent::cadastro($this->service, $this->form);
    }
    public function excluirAction()
    {
        return parent::excluir($this->service, $this->form);
}

 public function indexPaginationAction()
    {// funcao paginacao
        //http://igorrocha.com.br/tutorial-zf2-parte-9-paginacao-busca-e-listagem/4/

        $filter = $this->getFilterPage();

        $camposFilter = [
            '0' => [
                'filter' => "responsavel.nm_responsavel LIKE ?",
            ],
            
            
             '1' => [
                'filter' => "responsavel.tx_observacao LIKE ?",
            ],
            
             '2' => [
                'filter' => "responsavel.cs_participa_movimento_pastoral LIKE ?",
            ],

        ];

        $paginator = $this->service->getResponsavelPaginator($filter, $camposFilter);

        $paginator->setItemCountPerPage($paginator->getTotalItemCount());

        $countPerPage = $this->getCountPerPage(
            current(\Estrutura\Helpers\Pagination::getCountPerPage($paginator->getTotalItemCount()))
        );

        $paginator->setItemCountPerPage($this->getCountPerPage(
            current(\Estrutura\Helpers\Pagination::getCountPerPage($paginator->getTotalItemCount()))
        ))->setCurrentPageNumber($this->getCurrentPage());

        $viewModel = new ViewModel([
            'service' => $this->service,
            'form' => $this->form,
            'paginator' => $paginator,
            'filter' => $filter,
            'countPerPage' => $countPerPage,
            'camposFilter' => $camposFilter,
            'controller' => $this->params('controller'),
            'atributos' => array()
        ]);

        return $viewModel->setTerminal(TRUE);
    }

}



    