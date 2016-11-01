<?php

namespace SituacaoResponsavelCatequizando\Controller;

use Estrutura\Controller\AbstractCrudController;
use Estrutura\Helpers\Cript;
use Estrutura\Helpers\Data;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

class SituacaoResponsavelCatequizandoController extends AbstractCrudController
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
        $this->getRequest()->getPost()->set('id_catequizando', $this->getRequest()->getPost()->get('id_catequizando'));
       $this->getRequest()->getPost()->set('id_situacao_responsavel', $this->getRequest()->getPost()->get('id_situacao_responsavel'));
        
       
       parent::gravar(
                            $this->getServiceLocator()->get('\SituacaoResponsavelCatequizando\Service\SituacaoResponsavelCatequizandoService'), new \SituacaoResponsavelCatequizando\Form\SituacaoResponsavelCatequizandoForm()
            );
       $this->addSuccessMessage('Registro Inserido/Alterado com sucesso');
        $this->redirect()->toRoute('navegacao', array('controller' => 'situacao_responsavel_catequizando-situacaoresponsavelcatequizando', 'action' => 'index'));
       
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
            '0' => [
                'filter' => "catequizando.nm_catequizando LIKE ?",
            ],
            
             '1' => [
                'filter' => "situacao_responsavel.ds_situacao_responsavel LIKE ?" ,
            ],
         
        ];
        
        $paginator = $this->service->getSituacaoResponsavelCatequizandoPaginator($filter, $camposFilter);

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



    