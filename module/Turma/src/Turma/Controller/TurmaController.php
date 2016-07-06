<?php

namespace Turma\Controller;

use Estrutura\Controller\AbstractCrudController;
use Estrutura\Helpers\Cript;
use Estrutura\Helpers\Data;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

class TurmaController extends AbstractCrudController
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

        //GRAVANDO CATEQUISTA

  // INSERINDO CAMPOS COM FKS NA TABELA TURMA 
        $turmaService = $this->getServiceLocator()->get('\Turma\Service\TurmaService');
        $turmaService->setIdEtapa(trim($this->getRequest()->getPost()->get('id_etapa')));
        
        
        ///INSERINDO CAMPOS DA TABELA TURMA
        $turmaService->setCdTurma(trim($this->getRequest()->getPost()->get('cd_turma')));
        $turmaService->setNmTurma(trim($this->getRequest()->getPost()->get('nm_turma')));
        
        
        parent::gravar(
                            $this->getServiceLocator()->get('\Turma\Service\TurmaService'), new \Turma\Form\TurmaForm()
            );
    
    $this->addSuccessMessage('Registro Inserido/Alterado com sucesso');
    $this->redirect()->toRoute('navegacao', array('controller' => 'turma-turma', 'action' => 'index'));
        
   
    }
 
  public function cadastroAction()
    { 
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
                'filter' => "turma.nm_turma LIKE ?",
            ],

        ];

        $paginator = $this->service->getTurmaPaginator($filter, $camposFilter);

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






    