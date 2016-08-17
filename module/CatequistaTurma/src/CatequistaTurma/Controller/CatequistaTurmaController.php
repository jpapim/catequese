<?php

namespace CatequistaTurma\Controller;

use Estrutura\Controller\AbstractCrudController;
use Estrutura\Helpers\Cript;
use Estrutura\Helpers\Data;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

class CatequistaTurmaController extends AbstractCrudController
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
    
    
     public function gravarAction()
    {

        
        $this->getRequest()->getPost()->set('id_turma', $this->getRequest()->getPost()->get('id_turma'));
       $this->getRequest()->getPost()->set('id_catequista', $this->getRequest()->getPost()->get('id_catequista'));

        parent::gravar(
            $this->getServiceLocator()->get('\CatequistaTurma\Service\CatequistaTurmaService'), new \CatequistaTurma\Form\CatequistaTurmaForm()
        );

        $this->addSuccessMessage('Registro Inserido/Alterado com sucesso');
        $this->redirect()->toRoute('navegacao', array('controller' => 'catequista_turma-catequistaturma', 'action' => 'index'));
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

        $filter = $this->getFilterPage();
        $camposFilter = [
            '0' => [
                'filter' => "turma.nm_turma LIKE ?",
            ],
            '1' => [
                'filter' => "catequista.nm_catequista LIKE ?",
            ],
            '2' => NULL,

        ];

        $paginator = $this->service->getCatequistaTurmaPaginator($filter, $camposFilter);
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


    public function detalhePaginationAction()
    {
        $filter = $this->getFilterPage();

        $id_turma = $this->params()->fromPost('id_turma');
        $id_catequista = $this->params()->fromPost('id_catequista');

        $camposFilter = [
            '0' => [
                'filter' => "turma.nm_turma LIKE ?",
            ],
            '1' => [
                'filter' => "catequista.nm_catequista LIKE ?",
            ],
            
            '2' => NULL,

        ];

        #xd($id_turma);
        $paginator = $this->service->getCatequistaTurmaInternoPaginator($id_turma, $id_catequista, $filter, $camposFilter);

        $paginator->setItemCountPerPage($paginator->getTotalItemCount());

        $countPerPage = $this->getCountPerPage(
            current(\Estrutura\Helpers\Pagination::getCountPerPage($paginator->getTotalItemCount()))
        );

        $paginator->setItemCountPerPage($this->getCountPerPage(
            current(\Estrutura\Helpers\Pagination::getCountPerPage($paginator->getTotalItemCount()))
        ))->setCurrentPageNumber($this->getCurrentPage());

        $viewModel = new ViewModel([
            'service' => $this->service,
            'form' => new \CatequistaTurma\Form\CatequistaTurmaForm(),
            'paginator' => $paginator,
            'filter' => $filter,
            'countPerPage' => $countPerPage,
            'camposFilter' => $camposFilter,
            'controller' => $this->params('controller'),
            'id_turma' => $id_turma,
            'id_catequista' => $id_catequista,
            'atributos' => array()
        ]);

        return $viewModel->setTerminal(TRUE);
    }

    

}




    