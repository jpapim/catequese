<?php

namespace CatequistaEtapaAtuacao\Controller;

use Estrutura\Controller\AbstractCrudController;
use Estrutura\Helpers\Cript;
use Estrutura\Helpers\Data;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

class CatequistaEtapaAtuacaoController extends AbstractCrudController
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

  // INSERINDO CAMPOS COM FKS DA TABELA
       $this->getRequest()->getPost()->set('id_etapa', $this->getRequest()->getPost()->get('id_etapa'));
       $this->getRequest()->getPost()->set('id_catequista', $this->getRequest()->getPost()->get('id_catequista'));
       $this->getRequest()->getPost()->set('dt_cadastro', $dateCadastro);
        
       
           parent::gravar(
                            $this->getServiceLocator()->get('\CatequistaEtapaAtuacao\Service\CatequistaEtapaAtuacaoService'), new \CatequistaEtapaAtuacao\Form\CatequistaEtapaAtuacaoForm()
            );
    
    $this->addSuccessMessage('Registro Inserido/Alterado com sucesso');
    $this->redirect()->toRoute('navegacao', array('controller' => 'catequista_etapa_atuacao-catequistaetapaatuacao', 'action' => 'index'));
  
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
                'filter' => "etapa.nm_etapa LIKE ?",
            ],
              '1' => [
                 'filter' => "catequista.nm_catequista LIKE ?",
            ],
            
              '2' => [
                 'filter' => "catequista_etapa_atuacao.dt_cadastro LIKE ?",
            ],
            '3' => NULL,
              
            
            
        ];
        
        $paginator = $this->service->getCatequistaEtapaAtuacaoPaginator($filter, $camposFilter);

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
