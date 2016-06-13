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

        #xd($_POST['dt_inicio']);
        $controller = $this->params('controller');
        $id_periodo_letivo = parent::gravar($service,$form);
        #xd($id_periodo_letivo);
        #$this->addSuccessMessage('Registro Alterado com sucesso!');
        $this->redirect()->toRoute('navegacao',array('controller'=>$controller,'action'=>'cadastroperiodoletivodetalhe','id'=>$id_periodo_letivo));

        return $id_periodo_letivo;
    }

    public function excluirAction(){
        return parent::excluir($this->service,$this->form);
    }
    public function cadastroAction(){
        return parent::cadastro($this->service,$this->form);
    }

    public function cadastroperiodoletivodetalheAction()
    {
        //recuperar o id do Periodo Letivo
        $id_periodo_letivo = $this->params('id');

        $periodo_letivo = new \PeriodoLetivo\Service\PeriodoLetivoService();
        $dadosPeriodoLetivo = $periodo_letivo->buscar($id_periodo_letivo);

            $dadosView = [
                'service' => new \DetalhePeriodoLetivo\Service\detalhePeriodoLetivoService(),
                'form' => new \DetalhePeriodoLetivo\Form\DetalhePeriodoLetivoForm(), //$this->form,
                'controller' => $this->params('controller'),
                'atributos' => array(),
                'id_periodo_letivo' => $id_periodo_letivo,
                'dadosPeriodoLetivo' => $dadosPeriodoLetivo,
            ];

            return new ViewModel($dadosView);
        //}
    }

    public function adicionarperiodoletivodetalheAction()
    {
        //Se for a chamada Ajax
        if ($this->getRequest()->isPost()) {
            $id_detalhe_periodo_letivo = $this->params()->fromPost('id_detalhe_periodo_letivo');
            $id_periodo_letivo = $this->params()->fromPost('id_periodo_letivo');
            $dt_encontro = $this->params()->fromPost('dt_encontro');

            xd($dt_encontro);

            $atleta = new \Atleta\Service\AtletaService();
            $arrAtleta = $atleta->getIdAtletaPorNomeToArray($this->params()->fromPost('nm_atleta'));
            $realizar_inscricao = new \InscricoesEvento\Service\InscricoesEventoService();

            //TODO - Implementar Validador para certificar que o Atleta ainda nao esta na base.
            if($realizar_inscricao->checarSeAtletaEstaInscritoNoEvento($arrAtleta['id_atleta'],$id_evento)){
                $valuesJson = new JsonModel( array('sucesso'=>false, 'nm_atleta'=>$nm_atleta) );
            }else{
                $id_inserido = $realizar_inscricao->getTable()->salvar(array('id_evento'=>$id_evento, 'id_atleta'=>$arrAtleta['id_atleta']), null);
                $valuesJson = new JsonModel( array('id_inserido'=>$id_inserido, 'sucesso'=>true, 'nm_atleta'=>$nm_atleta) );
            }

            return $valuesJson;
        }
    }

    public function detalhePaginationAction()
    {
        $filter = $this->getFilterPage();

        $camposFilter = [
            '0' => [
                //'filter' => "periodoletivodetalhe.nm_sacramento LIKE ?",
            ],

        ];

        $paginator = $this->service->getPeriodoLetivoDetalhePaginator($filter, $camposFilter);

        $paginator->setItemCountPerPage($paginator->getTotalItemCount());

        $countPerPage = $this->getCountPerPage(
            current(\Estrutura\Helpers\Pagination::getCountPerPage($paginator->getTotalItemCount()))
        );

        $paginator->setItemCountPerPage($this->getCountPerPage(
            current(\Estrutura\Helpers\Pagination::getCountPerPage($paginator->getTotalItemCount()))
        ))->setCurrentPageNumber($this->getCurrentPage());

        $viewModel = new ViewModel([
            'service' => $this->service,
            'form' => new \DetalhePeriodoLetivo\Form\DetalhePeriodoLetivoForm(),
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