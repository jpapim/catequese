<?php

namespace FrequenciaTurma\Controller;

use Estrutura\Controller\AbstractCrudController;
use Estrutura\Helpers\Cript;
use Estrutura\Helpers\Data;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

class FrequenciaTurmaController extends AbstractCrudController
{

    protected $service;
    protected $form;

    public function __construct()
    {
        parent::init();
    }

    public function indexAction()
    {
        return parent::index($this->service, $this->form);

        return new ViewModel([
            'service' => $this->service,
            'form' => $this->form,
            'controller' => $this->params('controller'),
            'atributos' => array()
        ]);
    }

    public function indexPaginationAction()
    {// funcao paginacao

        $filter = $this->getFilterPage();
        $camposFilter = [
            '0' => [
                'filter' => "frequencia_turma.id_frequencia_turma LIKE ?",
            ],
            '1' => [
                'filter' => "turma_catequizando.id_turma_catequizando LIKE ?",
            ],
            '2' => [
                'filter' => "detalhe_periodo_letivo.id_detalhe_periodo_letivo LIKE ?",
            ],
            '3' => NULL,

        ];

        $paginator = $this->service->getFrequenciaTurmaPaginator($filter, $camposFilter);
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

    public function frequenciaAction(){

        $dados=[
            'form'=> new \FrequenciaTurma\Form\FrequenciaForm(),
            'service'=>$this->service,
            'controller'=>$this->params('controller')
        ];
        $view = new ViewModel($dados);
        return $view;
    }

    public function listarTurmaCatequizandoAction(){

        if($this->getRequest()->isPost()){
           $post = \Estrutura\Helpers\Utilities::arrayMapArray('trim',$this->params()->fromPost());

            $turCatServ = new \TurmaCatequizando\Service\TurmaCatequizandoService();
            $arrTurCat = $turCatServ->fetchAllById(['id_turma = ?'=>$post['id_turma']]);
            $arrTurCat = array_unique($arrTurCat, SORT_REGULAR);
            #xd($arrTurCat);
            /** @var $catServ \Catequizando\Service\CatequizandoService */
            $catServ= $this->getServiceLocator()->get('\Catequizando\Service\CatequizandoService');
            $listaCatequizandos = [];
            foreach($arrTurCat as  $key => $item){
                $listaCatequizandos[$key] = $catServ->buscar($item['id_catequizando'])->toArray();
                $listaCatequizandos[$key]['id_turma_catequizado']=$item['id_turma_catequizando'];
            }
            /** @var $obDetPeriodoLetivo \DetalhePeriodoLetivo\Service\DetalhePeriodoLetivoService */
            $obDetPeriodoLetivo= new \DetalhePeriodoLetivo\Service\DetalhePeriodoLetivoService();
            $encontros = $obDetPeriodoLetivo->fetchAllById(['id_periodo_letivo = ? ORDER BY (dt_encontro) ASC'=>$arrTurCat[0]['id_periodo_letivo']]);

            $encontroFiltrado = [];
            foreach($encontros as $key => $encontro){
                $encontro['dt_encontro'] = \Estrutura\Helpers\Data::converterDataBancoMySQL2Brazil($encontro['dt_encontro']);
                $encontroFiltrado[$key] =$encontro;
            }

            #xd($listaCatequizandos);
            #xd($encontroFiltrado);
            $dados=[
                'lista'=>$listaCatequizandos,
                'encontros'=>$encontroFiltrado,
                'controller'=>$this->params('controller'),


            ];

            $view = new ViewModel($dados);

            return $view->setTerminal(true);
        }
    }

    public function carregarComboTurmasAjaxAction(){

        if(!$this->getRequest()->isPost()){
            throw new \Exception('Dados inválidos');
        }

        $post = \Estrutura\Helpers\Utilities::arrayMapArray('trim',$this->params()->fromPost());
        $id_etapa = $post['id_etapa'];

        #
        $turmaServ = new \Turma\Service\TurmaService();
        $arrTurma = $turmaServ->fetchAllById(['id_etapa = ?'=>$post['id_etapa']]);

        $arrTurma = array_unique($arrTurma,SORT_REGULAR);
        $arrTurmaCombo =[];
        foreach($arrTurma as $key => $item){
            $arrTurmaCombo[$key]['id']= $item['id_turma'];
            $arrTurmaCombo[$key]['nm_turma'] = $item['nm_turma'];
        }

        if(count($arrTurmaCombo) >0){
            $valueJson = new JsonModel(['ar_turmas'=>$arrTurmaCombo,'sucesso'=>true,]);
        }else{
            $arrTurmaCombo[0]['id']="";
            $arrTurmaCombo[0]['nm_turma']='Não existe turma nessa etapa.';
            $valueJson = new JsonModel(['ar_turmas'=>$arrTurmaCombo,'sucesso'=>true,]);
        }
        #xd($valueJson);
        return $valueJson;
    }

    public function gravarPresencaAction(){
        if($this->getRequest()->isPost()){
            try{
                $value=null;
                $post = $this->params()->fromPost('form');

                if(empty($post)){
                   $value = new JsonModel(['sucesso'=>false, 'msg'=>'Não foi possível gravar a lista de presença (lista vazia).']);
                    return $value;
                }

                $cate_faltas=[];
                foreach($post as $key => $p):
                    $p = explode('_',$p);
                    $cate_faltas[$key]=[
                        'id_turma_catequizando'=>$p[0],
                        'id_detalhe_periodo_letivo'=>$p[1]
                    ];
                endforeach;

                $bool =[];
                foreach($cate_faltas as $freq):
                    $this->getRequest()->getPost()->set('id_turma_catequizando',$freq['id_turma_catequizando']);
                    $this->getRequest()->getPost()->set('id_detalhe_periodo_letivo',$freq['id_detalhe_periodo_letivo']);

                 $bool[]=   parent::gravar(
                        $this->service,$this->form
                    );
                endforeach;

                if($bool){
                    $value = new JsonModel([
                        'sucesso'=>true,
                    ]);

                }
            }catch (\Exception $e){
                $value = new JsonModel([
                    'sucesso'=>false,
                    'msg'=>'Não foi possível gravar a lista de presença:'.$e->getMessage()
                ]);

            }
            return $value;
        }
    }

}