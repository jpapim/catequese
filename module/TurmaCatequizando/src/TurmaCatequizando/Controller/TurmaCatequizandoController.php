<?php

namespace TurmaCatequizando\Controller;

use Estrutura\Controller\AbstractCrudController;
use Estrutura\Helpers\Cript;
use Estrutura\Helpers\Data;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

class TurmaCatequizandoController extends AbstractCrudController
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

    public function gravarAction()
    {

        // FORMATANDO AS DATAS RECEBIDAS     
        $dateCadastro = \DateTime::createFromFormat('d/m/Y', $this->getRequest()->getPost()->get('dt_cadastro'));

        //GRAVANDO 

        // INSERINDO CAMPOS COM FKS NA TABELA TURMA
        $turmaCatequizandoService = $this->getServiceLocator()->get('\TurmaCatequizando\Service\TurmaCatequizandoService');
        $turmaCatequizandoService->setIdTurma(trim($this->getRequest()->getPost()->get('id_turma')));
        // $turmaCatequizandoService->setIdCatequizando(trim($this->getRequest()->getPost()->get('id_catequizando')));
        $turmaCatequizandoService->setIdUsuario(trim($this->getRequest()->getPost()->get('id_usuario')));
        $turmaCatequizandoService->setIdPeriodoLetivo(trim($this->getRequest()->getPost()->get('id_periodo_letivo')));

        ///INSERINDO CAMPOS DA TABELA TURMA
        $turmaCatequizandoService->setCdTurma(trim($this->getRequest()->getPost()->get($dateCadastro)));
        $turmaCatequizandoService->setNmTurma(trim($this->getRequest()->getPost()->get('cs_aprovado')));
        $turmaCatequizandoService->setNmTurma(trim($this->getRequest()->getPost()->get('ds_motivo_reprovacao')));
        $turmaCatequizandoService->setNmTurma(trim($this->getRequest()->getPost()->get('tx_observacoes')));

        parent::gravar(
            $this->getServiceLocator()->get('\TurmaCatequizando\Service\TurmaCatequizandoService'), new \TurmaCatequizando\Form\TurmaCatequizandoForm()
        );

        $this->addSuccessMessage('Registro Inserido/Alterado com sucesso');
        $this->redirect()->toRoute('navegacao', array('controller' => 'turma_catequizando-turmacatequizando', 'action' => 'index'));
    }

    public function cadastroAction()
    {
        //Se for chamado via formulario de altera�ao
        if ($this->params('id_turma') && $this->params('id_periodo_letivo')) {
            $id_turma = Cript::dec($this->params('id_turma'));
            $id_periodo_letivo = Cript::dec($this->params('id_periodo_letivo'));

            $arAtributos = array(
                'id_turma' => $id_turma,
                'id_periodo_letivo' => $id_periodo_letivo,

            );
            $this->form->setData($arAtributos);

            $dadosView = [
                'service' => $this->service,
                'form' => $this->form,
                'controller' => $this->params('controller'),
                'atributos' => array(),
                'id_turma' => $id_turma,
                'id_periodo_letivo' => $id_periodo_letivo,
            ];
            return new ViewModel($dadosView);

        } else { #Se for chamado via botao de cadastro
            return parent::cadastro($this->service, $this->form);
        }

    }

    public function excluirAction()
    {
        return parent::excluir($this->service, $this->form);
    }
    
      public function aprovacaoAction()
    {
        return parent::cadastro($this->service, $this->form);
    }

    public function indexPaginationAction()
    {// funcao paginacao

        $filter = $this->getFilterPage();
        $camposFilter = [
            '0' => NULL,
            '1' => [
                'filter' => "turma.nm_turma LIKE ?",
            ],
            '2' => [
                'filter' => "periodo_letivo.dt_ano_letivo LIKE ?",
            ],
            '3' => NULL,

        ];

        $paginator = $this->service->getTurmaCatequizandoPaginator($filter, $camposFilter);
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


    public function detalhePaginationAction()
    {
        $filter = $this->getFilterPage();

        $id_turma = $this->params()->fromPost('id_turma');
        $id_periodo_letivo = $this->params()->fromPost('id_periodo_letivo');

        $camposFilter = [
            '0' => [
                'filter' => "turma.nm_turma LIKE ?",
            ],
            '1' => [
                'filter' => "periodo_letivo.dt_ano_letivo LIKE ?",
            ],
            '2' => [
                'filter' => "catequizando.nm_catequizando LIKE ?",
            ],
            '3' => NULL,

        ];

        #xd($id_turma);
        $paginator = $this->service->getTurmaCatequizandoInternoPaginator($id_turma, $id_periodo_letivo, $filter, $camposFilter);


        $paginator->setItemCountPerPage($paginator->getTotalItemCount());

        $countPerPage = $this->getCountPerPage(
            current(\Estrutura\Helpers\Pagination::getCountPerPage($paginator->getTotalItemCount()))
        );

        $paginator->setItemCountPerPage($this->getCountPerPage(
            current(\Estrutura\Helpers\Pagination::getCountPerPage($paginator->getTotalItemCount()))
        ))->setCurrentPageNumber($this->getCurrentPage());


        $viewModel = new ViewModel([
            'service' => $this->service,
            'form' => new \TurmaCatequizando\Form\TurmaCatequizandoForm(),
            'paginator' => $paginator,
            'filter' => $filter,
            'countPerPage' => $countPerPage,
            'camposFilter' => $camposFilter,
            'controller' => $this->params('controller'),
            'id_turma' => $id_turma,
            'id_periodo_letivo' => $id_periodo_letivo,
            'atributos' => array()
        ]);

        return $viewModel->setTerminal(TRUE);
    }

    public function enturmarAlunoAction()
    {
        //Se for a chamada Ajax
        if ($this->getRequest()->isPost()) {
            $id_turma = $this->params()->fromPost('id_turma');
            $id_periodo_letivo = $this->params()->fromPost('id_periodo_letivo');
            $id_catequizando = $this->params()->fromPost('id_catequizando');

            $cateService = new \Catequizando\Service\CatequizandoService();
            $id_catequizando = $cateService->getFiltrarCatequizandoPorNomeToArray($id_catequizando)->current();


            #xd($id_catequizando);
            $id_usuario = $this->params()->fromPost('id_usuario');
            $tx_observacoes = $this->params()->fromPost('tx_observacoes');

            $obj_turma_catequizando = new \TurmaCatequizando\Service\TurmaCatequizandoService();
            $obj_turma_catequizando->setIdCatequizando($id_catequizando['id_catequizando']);
            if($obj_turma_catequizando->filtrarObjeto()->count() > 0){
                $this->addInfoMessage('Catequizando já está enturmado');
                return false;
            }

            $arDadosGravar = array(
                'id_catequizando' => $id_catequizando['id_catequizando'],
                'id_periodo_letivo' => $id_periodo_letivo,
                'id_turma' => $id_turma,
                'id_usuario' => $id_usuario,
                'tx_observacoes' => $tx_observacoes
            );
            $id_inserido = $obj_turma_catequizando->getTable()->salvar($arDadosGravar, null);
            $valuesJson = new JsonModel(array('id_inserido' => $id_inserido, 'sucesso' => true, 'id_periodo_letivo' => $id_periodo_letivo, 'id_turma' => $id_turma));

            return $valuesJson;
        }
    }

    public function excluirCatequizandoTurmaAction()
    {

        try {
            $request = $this->getRequest();

            if ($request->isPost()) {
                return new JsonModel();
            }

            $controller = $this->params('controller');

            $id_turma_catequizando = Cript::dec($this->params('id_turma_catequizando'));
            $id_turma = Cript::dec($this->params('id_turma'));
            $id_periodo_letivo = Cript::dec($this->params('id_periodo_letivo'));

            $this->service->setId($id_turma_catequizando);

            $dados = $this->service->filtrarObjeto()->current();

            if (!$dados) {
                throw new \Exception('Registro não encontrado');
            }

            $this->service->excluir();
            $this->addSuccessMessage('Registro excluido com sucesso');
            return $this->redirect()->toRoute('turma_catequizando', array('controller' => 'turma_catequizando-turmacatequizando', 'action' => 'cadastro', 'id_turma' => \Estrutura\Helpers\Cript::enc($id_turma), 'id_periodo_letivo' => \Estrutura\Helpers\Cript::enc($id_periodo_letivo) ));
        } catch (\Exception $e) {
            if (strstr($e->getMessage(), '1451')) { #ERRO de SQL (Mysql) para nao excluir registro que possua filhos
                $this->addErrorMessage('Para excluir este registro, apague todos os filhos deste registro primeiro!');
            } else {
                $this->addErrorMessage($e->getMessage());
            }

            return $this->redirect()->toRoute('navegacao', ['controller' => $controller]);
        }

        return parent::excluir($this->service, $this->form);
    }
    
    public function aprovacaoPaginationAction()
    {
        $filter = $this->getFilterPage();

        $id_turma = $this->params()->fromPost('id_turma');
        $id_etapa = $this->params()->fromPost('id_etapa');

        $camposFilter = [
            '0' => [
                'filter' => "catequizando.nm_catequizando LIKE ?",
            ],
            
            

        ];

        #xd($id_turma);
        $paginator = $this->service->getAprovacaoCatequizandoPaginator($id_turma, $id_etapa, $filter, $camposFilter);

        $paginator->setItemCountPerPage($paginator->getTotalItemCount());

        $countPerPage = $this->getCountPerPage(
            current(\Estrutura\Helpers\Pagination::getCountPerPage($paginator->getTotalItemCount()))
        );

        $paginator->setItemCountPerPage($this->getCountPerPage(
            current(\Estrutura\Helpers\Pagination::getCountPerPage($paginator->getTotalItemCount()))
        ))->setCurrentPageNumber($this->getCurrentPage());

        $viewModel = new ViewModel([
            'service' => $this->service,
            'form' => new \TurmaCatequizando\Form\TurmaCatequizandoForm(),
            'paginator' => $paginator,
            'filter' => $filter,
            'countPerPage' => $countPerPage,
            'camposFilter' => $camposFilter,
            'controller' => $this->params('controller'),
            'id_turma' => $id_turma,
            'id_etapa' => $id_etapa,
            'atributos' => array()
        ]);

        return $viewModel->setTerminal(TRUE);
} 
public function listarAprovadoAction(){
     return parent::cadastro($this->service, $this->form);
     
        }
        
          public function gravarAprovacaoAction(){
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
                        #'id_catequizando'=>$p[1],
                        'cs_aprovado'=>$p[1]
                    ];
                endforeach;

                $bool =[];
                foreach($cate_faltas as $freq){
                  $this->getRequest()->getPost()->set('id',$freq['id_turma_catequizando']);
                 $this->getRequest()->getPost()->set('id_turma_catequizando',$freq['id_turma_catequizando']);
                   #$this->getRequest()->getPost()->set('id_catequizando',$freq['id_catequizando']);
                    $this->getRequest()->getPost()->set('cs_aprovado',$freq['cs_aprovado']);

                 $bool[]=   parent::gravar(
                       $this->getServiceLocator()->get('\TurmaCatequizando\Service\TurmaCatequizandoService'),new \TurmaCatequizando\Form\TurmaCatequizandoAprovacaoForm()
                    );
                    }
                    
                    

                if($bool){
                    $value = new JsonModel([
                    'sucesso'=>TRUE,
                   
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
    
    


    

    

    


    