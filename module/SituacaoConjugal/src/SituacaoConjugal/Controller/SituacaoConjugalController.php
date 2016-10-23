<?php
/**
 * Created by PhpStorm.
 * User: IGOR
 * Date: 12/07/2016
 * Time: 14:05
 */

namespace SituacaoConjugal\Controller;


use Estrutura\Controller\AbstractCrudController;
use Estrutura\Helpers\Pagination;
use SituacaoConjugal\Form\SituacaoConjugalForm;
use SituacaoConjugal\Service\SituacaoConjugalService;
use Zend\View\Model\ViewModel;

class SituacaoConjugalController extends  AbstractCrudController{

    /** @var  SituacaoConjugalService*/
    protected $service;
    /** @var  SituacaoConjugalForm*/
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
    {// funcao paginacao
        //http://igorrocha.com.br/tutorial-zf2-parte-9-paginacao-busca-e-listagem/4/

        $filter = $this->getFilterPage();

        $camposFilter = [
            '0' => [
                'filter' => "situacao_conjugal.ds_situacao_conjugal LIKE ?",
            ],

        ];

        $paginator = $this->service->getSituacaoConjugalPaginator($filter, $camposFilter);

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