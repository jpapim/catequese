<?php
/**
 * Created by PhpStorm.
 * User: IGOR
 * Date: 08/06/2016
 * Time: 13:51
 */

namespace PeriodoLetivo\Controller;



use Estrutura\Controller\AbstractCrudController;
use Estrutura\Helpers\Data;
use Estrutura\Helpers\Pagination;
use Zend\View\Model\ViewModel;
use Zend\Form\Element;


class PeriodoLetivoController extends AbstractCrudController {

    /**
     * @var \PeriodoLetivo\Service\PeriodoLetivo
     */
    protected  $service;
    /**
     * @var \PeriodoLetivo\Form\PeriodoLetivo
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
                'filter' => "periodo_letivo.id_periodo_letivo  LIKE ?"
            ],
            '1'=>[
                'filter' => "periodo_letivo.dt_inicio  LIKE ?"
            ],
            '2'=>[
                'filter'=> "periodo_letivo.dt_fim  LIKE ?"
            ],
            '3'=>[
                'filter'=> "periodo_letivo.dt_ano_letivo  LIKE ?"
            ]

        ];

        $paginator = $this->service->getPeriodoLetivoPaginator($filter, $camposFilter);
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
        $form = new \PeriodoLetivo\Form\PeriodoLetivoForm();
        $service =  new \PeriodoLetivo\Service\PeriodoLetivoService();

        $_POST['dt_inicio']= Data::converterDataHoraBrazil2BancoMySQL($_POST['dt_inicio']);
        $_POST['dt_fim']= Data::converterDataHoraBrazil2BancoMySQL($_POST['dt_fim']);

        $controller = $this->params('controller');
        $this->addSuccessMessage('Registro Alterado com sucesso!');
        $this->redirect()->toRoute('navegacao',array('controller'=>$controller,'action'=>'index'));

        return parent::gravar($service,$form);
    }

    public function excluirAction(){
        return parent::excluir($this->service,$this->form);
    }
    public function cadastroAction(){
        return parent::cadastro($this->service,$this->form);
    }



} 