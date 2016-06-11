<?php
/**
 * Created by PhpStorm.
 * User: IGOR
 * Date: 10/06/2016
 * Time: 13:17
 */

namespace DetalhePeriodoLetivo\Controller;


use Estrutura\Controller\AbstractCrudController;
use Estrutura\Helpers\Data;
use Estrutura\Helpers\Pagination;
use Zend\View\Model\ViewModel;
use Zend\Form\Element;


class DetalhePeriodoLetivoController extends AbstractCrudController {

    /**
     * @var \DetalhePeriodoLetivo\Service\DetalhePeriodo
     */
     protected  $service;

    /**
     * @var \DetalhePeriodoLetivo\Form\DetalhePeriodo
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
                'filter' => "detalhe_periodo_letivo.id_detalhe_periodo_letivo  LIKE ?"
            ],
            '1'=>[
                'filter' => "detalhe_periodo_letivo.id_periodo_letivo  LIKE ?"
            ],
            '2'=>[
                'filter'=> "detalhe_periodo_letivo.dt_encontro  LIKE ?"
            ],


        ];

        $paginator = $this->service->getDetalhePeriodoLetivoPaginator($filter, $camposFilter);
        $paginator->setItemCountPerPage($paginator->getTotalItemCount());
        $countPerPage = $this->getCountPerPage(
            current(Pagination::getCountPerPage($paginator->getTotalItemCount()))
        );

        $paginator->setItemCountPerPage($this->getCountPerPage(
            current(Pagination::getCountPerPage($paginator->getTotalItemCount()))
        ))->setCurrentPageNumber($this->getCurrentPage());

        $viewModel = new ViewModel([
            'service'=>$this->service,
            'form'=>$this->form,
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

        $_POST['dt_encontro']= Data::converterDataHoraBrazil2BancoMySQL($_POST['dt_encontro']);
        $controller = $this->params('controller');
        $this->addSuccessMessage('Registro Alterado com sucesso!');
        $this->redirect()->toRoute('navegacao',array('controller'=>$controller,'action'=>'index'));

        return parent::gravar($this->service,$this->form);
    }

    public function excluirAction(){
        return parent::excluir($this->service,$this->form);
    }
    public function cadastroAction(){
        return parent::cadastro($this->service,$this->form);
    }

}
