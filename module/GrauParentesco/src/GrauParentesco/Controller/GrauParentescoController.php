<?php

namespace GrauParentesco\Controller;

use Estrutura\Controller\AbstractCrudController;
use Estrutura\Helpers\Cript;
use Estrutura\Helpers\Data;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

class GrauParentescoController extends AbstractCrudController
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
        
        $controller =  $this->params('controller');
     

        $pos = $this->getRequest()->getPost()->toArray();
       

        
        
            $Grau = $this->getServiceLocator()->get('\GrauParentesco\Service\GrauParentescoService');
            $Grau->setNmGrauParentesco(trim($this->getRequest()->getPost()->get('nm_grau_parentesco')));
            if ($Grau->filtrarObjeto()->count()) {

                if ($Grau->filtrarObjeto()->count()) {
               
                
                $this->addErrorMessage('Grau Parentesco já cadastrada');
                $this->redirect()->toRoute('navegacao', array('controller' => $controller, 'action' => 'index'));
               return FALSE;
            }}
           
              $this->getRequest()->getPost()->set('nm_grau_parentesco', $this->getRequest()->getPost()->get('nm_grau_parentesco'));
             $result = parent::gravar(
                                   $this->getServiceLocator()->get('\GrauParentesco\Service\GrauParentescoService'), new \GrauParentesco\Form\GrauParentescoForm()
                   ); 
                    $this->addSuccessMessage(' Grau Parentesco cadastrada com sucesso.');
                    $this->redirect()->toRoute('navegacao', array('controller' => 'grau_parentesco-grauparentesco', 'action' => 'index'));
      
    }

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
            '0' => NULL,
            '1' => [
                'filter' => "grau_parentesco.nm_grau_parentesco LIKE ?",
            ],
         
        ];
        
        $paginator = $this->service->getGrauParentescoPaginator($filter, $camposFilter);

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



    