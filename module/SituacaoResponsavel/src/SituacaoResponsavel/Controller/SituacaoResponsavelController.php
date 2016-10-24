<?php
/**
 * Created by PhpStorm.
 * User: IGOR
 * Date: 14/07/2016
 * Time: 12:58
 */

namespace SituacaoResponsavel\Controller;


use Estrutura\Controller\AbstractCrudController;
use Estrutura\Helpers\Pagination;
use SituacaoResponsavel\Form\SituacaoResponsavelForm;
use SituacaoResponsavel\Service\SituacaoResponsavelService;
use Zend\View\Model\ViewModel;

class SituacaoResponsavelController extends  AbstractCrudController {

    /** @var  SituacaoResponsavelService*/
    protected $service;
    /** @var  SituacaoResponsavelForm*/
    protected $form;


    public function  __construct()
    {
        parent::init();
    }
    public function indexAction()
    {
        return parent::index($this->service, $this->form);
    }

    

    public function gravarAction()
    {

        $controller = $this->params('controller');
        $this->addSuccessMessage('Registro Alterado com sucesso');
        $this->redirect()->toRoute('navegacao', array('controller' => $controller, 'action' => 'index'));
        return parent::gravar($this->service, $this->form);
    }

    public function cadastroAction()
    { //função de alterar
        return parent::cadastro($this->service, $this->form);
    }

    public function excluirAction()
    {
        return parent::excluir($this->service, $this->form);
    }
    public function indexPaginationAction()
    {

        $filter = $this->getFilterPage();

        $camposFilter =[
            '0' => [
                'filter' => "situacao_responsavel.ds_situacao_responsavel  LIKE ?"
            ],
            '1' => [
                'filter' => "situacao_responsavel.cs_pai_mae  LIKE ?"
            ],
            
            
        ];


        $paginator = $this->service->getSituacaoResponsavelPaginator($filter, $camposFilter);
        $paginator->setItemCountPerPage($paginator->getTotalItemCount());
        $countPerPage = $this->getCountPerPage(
            current(Pagination::getCountPerPage($paginator->getTotalItemCount()))
        );

        $paginator->setItemCountPerPage($this->getCountPerPage(
            current(Pagination::getCountPerPage($paginator->getTotalItemCount()))
        ))->setCurrentPageNumber($this->getCurrentPage());

        $viewModel = new ViewModel([
            'service' => $this->service,
            'form' => $this->form,
            'paginator' => $paginator,
            'filter' => $filter,
            'countPerPage' => $countPerPage,
            'camposFilter' => $camposFilter,
            'controller' => $this->params('controller'),
            'atributos' => array(),
        ]);

        return $viewModel->setTerminal(true);
    }
    
    
    
} 