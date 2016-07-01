<?php
/**
 * Created by PhpStorm.
 * User: IGOR
 * Date: 01/07/2016
 * Time: 14:34
 */

namespace DetalheFormacao\Controller;


use Estrutura\Controller\AbstractCrudController;
use Zend\View\Model\ViewModel;

class DetalheFormacaoController  extends  AbstractCrudController{

    /**
     * @var \DetalheFormacao\Service\DetalheFormacao
     */
    protected  $service;
    /**
     * @var \DetalheFormacao\Form\DetalheFormacao
     */
    protected $form;

    public function  __construct(){
        parent::init();
    }

    public function indexAction()
    {
        return parent::index($this->service,$this->form);
    }

    public function indexPaginationAction(){

        $filter = $this->getFilterPage();

        $camposFilter = [
            '0'=>[
                'filter' => "detalhe_formacao.id_detalhe_formacao  LIKE ?"
            ],
            '1'=>[
                'filter' => "detalhe_formacao.id_formacao  LIKE ?"
            ],
            '2'=>[
                'filter' => "detalhe_formacao.ds_deatalhe_formacao  LIKE ?"
            ],

        ];
        $paginator = $this->service->getDetalheFormacaoPaginator($filter, $camposFilter);

        $paginator->setItemCountPerPage($paginator->getTotalItemCount());

        $countPerPage = $this->getCountPerPage(
            current(\Estrutura\Helpers\Pagination::getCountPerPage($paginator->getTotalItemCount()))
        );

        $paginator->setItemCountPerPage($this->getCountPerPage(
            current(\Estrutura\Helpers\Pagination::getCountPerPage($paginator->getTotalItemCount()))
        ))->setCurrentPageNumber($this->getCurrentPage());

        $viewModel = new ViewModel([
            'service'=>$this->service,
            'formacao'=>$this->form,
            'paginator'=>$paginator,
            'filter'=>$filter,
            'countPerPage'=>$countPerPage,
            'camposFilter'=>$camposFilter,
            'controller'=>$this->params('controller'),
            'atributos'=>array(),
        ]);

        return $viewModel->setTerminal(true);
    }

    public function gravarAction(){
        $controller = $this->params('controller');
        $this->addSuccessMessage('Registro Alterado com sucesso');
        $this->redirect()->toRoute('navegacao', array('controller' => $controller, 'action' => 'index'));
        return parent::gravar($this->service, $this->form);
    }

    public function cadastroAction()
    {
        return parent::cadastro($this->service, $this->form);
    }

    public function excluirAction()
    {
        return parent::excluir($this->service, $this->form);
    }
} 