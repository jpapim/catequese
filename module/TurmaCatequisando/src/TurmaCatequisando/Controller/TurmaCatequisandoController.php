<?php

namespace TurmaCatequisando\Controller;

use Estrutura\Controller\AbstractCrudController;
use Estrutura\Helpers\Cript;
use Estrutura\Helpers\Data;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

class TurmaCatequisandoController extends AbstractCrudController
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
        $turmaCatequisandoService = $this->getServiceLocator()->get('\TurmaCatequisando\Service\TurmaCatequisandoService');
        $turmaCatequisandoService->setIdTurma(trim($this->getRequest()->getPost()->get('id_turma')));
        // $turmaCatequisandoService->setIdCatequisando(trim($this->getRequest()->getPost()->get('id_catequisando')));
        $turmaCatequisandoService->setIdUsuario(trim($this->getRequest()->getPost()->get('id_usuario')));
        $turmaCatequisandoService->setIdPeriodoLetivo(trim($this->getRequest()->getPost()->get('id_periodo_letivo')));

        ///INSERINDO CAMPOS DA TABELA TURMA
        $turmaCatequisandoService->setCdTurma(trim($this->getRequest()->getPost()->get($dateCadastro)));
        $turmaCatequisandoService->setNmTurma(trim($this->getRequest()->getPost()->get('cs_aprovado')));
        $turmaCatequisandoService->setNmTurma(trim($this->getRequest()->getPost()->get('ds_motivo_reprovacao')));
        $turmaCatequisandoService->setNmTurma(trim($this->getRequest()->getPost()->get('tx_observacoes')));

        parent::gravar(
            $this->getServiceLocator()->get('\TurmaCatequisando\Service\TurmaCatequisandoService'), new \TurmaCatequisando\Form\TurmaCatequisandoForm()
        );

        $this->addSuccessMessage('Registro Inserido/Alterado com sucesso');
        $this->redirect()->toRoute('navegacao', array('controller' => 'turma_catequisando-turmacatequisando', 'action' => 'index'));
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

    public function indexPaginationAction()
    {// funcao paginacao
        //http://igorrocha.com.br/tutorial-zf2-parte-9-paginacao-busca-e-listagem/4/

        $filter = $this->getFilterPage();

        $camposFilter = [
            # '0' => [
            #     'filter' => "turma_catequisando.dt_cadastro LIKE ?",
            # ],
            # '1' => [
            #     'filter' => "turma_catequisando.cs_aprovado LIKE ?",
            # ],#

            #'2' => [
            #    'filter' => "turma_catequisando.ds_motivo_reprovacao LIKE ?",
            #],
#
#            '3' => [
            #               'filter' => "turma_catequisando.tx_observacoes LIKE ?",
            #           ],

        ];

        $paginator = $this->service->getTurmaCatequisandoPaginator($filter, $camposFilter);

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
                //'filter' => "periodoletivodetalhe.nm_sacramento LIKE ?",
            ],

        ];

        #xd($id_turma);
        $paginator = $this->service->getTurmaCatequisandoInternoPaginator($id_turma, $id_periodo_letivo, $filter, $camposFilter);

        $paginator->setItemCountPerPage($paginator->getTotalItemCount());

        $countPerPage = $this->getCountPerPage(
            current(\Estrutura\Helpers\Pagination::getCountPerPage($paginator->getTotalItemCount()))
        );

        $paginator->setItemCountPerPage($this->getCountPerPage(
            current(\Estrutura\Helpers\Pagination::getCountPerPage($paginator->getTotalItemCount()))
        ))->setCurrentPageNumber($this->getCurrentPage());

        $viewModel = new ViewModel([
            'service' => $this->service,
            'form' => new \TurmaCatequisando\Form\TurmaCatequisandoForm(),
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
            $id_catequisando = $this->params()->fromPost('id_catequisando');
            $id_usuario = $this->params()->fromPost('id_usuario');
            $tx_observacoes = $this->params()->fromPost('tx_observacoes');

            $obj_turma_catequisando = new \TurmaCatequisando\Service\TurmaCatequisandoService();


            $arDadosGravar = array(
                'id_catequisando' => $id_catequisando,
                'id_periodo_letivo' => $id_periodo_letivo,
                'id_turma' => $id_turma,
                'id_usuario' => $id_usuario,
                'tx_observacoes' => $tx_observacoes
            );
            $id_inserido = $obj_turma_catequisando->getTable()->salvar($arDadosGravar, null);
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

            $id_turma_catequisando = Cript::dec($this->params('id_turma_catequisando'));
            $id_turma = Cript::dec($this->params('id_turma'));
            $id_periodo_letivo = Cript::dec($this->params('id_periodo_letivo'));

            $this->service->setId($id_turma_catequisando);

            $dados = $this->service->filtrarObjeto()->current();

            if (!$dados) {
                throw new \Exception('Registro não encontrado');
            }

            $this->service->excluir();
            $this->addSuccessMessage('Registro excluido com sucesso');
            return $this->redirect()->toRoute('turma_catequisando', array('controller' => 'turma_catequisando-turmacatequisando', 'action' => 'cadastro', 'id_turma' => \Estrutura\Helpers\Cript::enc($id_turma), 'id_periodo_letivo' => \Estrutura\Helpers\Cript::enc($id_periodo_letivo) ));
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

}


    