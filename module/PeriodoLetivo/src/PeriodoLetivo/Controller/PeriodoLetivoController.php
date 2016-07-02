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
use Zend\View\Model\JsonModel;
use Estrutura\Helpers\Cript;


class PeriodoLetivoController extends AbstractCrudController
{

    /**
     * @var \PeriodoLetivo\Service\PeriodoLetivo
     */
    protected $service;
    /**
     * @var \PeriodoLetivo\Form\PeriodoLetivo
     */
    protected $form;

    public function  __construct()
    {
        parent::init();
    }

    public function indexAction()
    {
        return parent::index($this->service, $this->form);
    }

    public function indexPaginationAction()
    {

        $filter = $this->getFilterPage();

        $camposFilter = [
            '0' => [
                'filter' => "periodo_letivo.id_periodo_letivo  LIKE ?"
            ],
            '1' => [
                'filter' => "periodo_letivo.dt_inicio  LIKE ?"
            ],
            '2' => [
                'filter' => "periodo_letivo.dt_fim  LIKE ?"
            ],
            '3' => [
                'filter' => "periodo_letivo.dt_ano_letivo  LIKE ?"
            ]

        ];

        #xd($id_periodo_letivo = $this->params('id'));

        $paginator = $this->service->getPeriodoLetivoPaginator($filter, $camposFilter);
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

    public function gravarAction()
    {
        try {
            $controller = $this->params('controller');
            $request = $this->getRequest();
            $service = $this->service;
            $form = $this->form;

            if (!$request->isPost()) {
                throw new \Exception('Dados Inválidos');
            }

            $post = \Estrutura\Helpers\Utilities::arrayMapArray('trim', $request->getPost()->toArray());

            $files = $request->getFiles();
            $upload = $this->uploadFile($files);

            $post = array_merge($post, $upload);

            if (isset($post['id']) && $post['id']) {
                $post['id'] = Cript::dec($post['id']);
            }
            #################################################################
            # Inicio da Customizaçao dos Valores antes de gravar no banco
            $post['dt_inicio'] = Data::converterDataHoraBrazil2BancoMySQL($post['dt_inicio']);
            $post['dt_fim'] = Data::converterDataHoraBrazil2BancoMySQL($post['dt_fim']);
            # Fim da Customizaçao dos Valores antes de gravar no banco
            #################################################################

            $form->setData($post);

            if (!$form->isValid()) {
                $this->addValidateMessages($form);
                $this->setPost($post);
                $this->redirect()->toRoute('navegacao', array('controller' => $controller, 'action' => 'cadastro'));
                return false;
            }
            $service->exchangeArray($form->getData());
            $this->addSuccessMessage('Registro Alterado com sucesso');
            $id_periodo_letivo = $service->salvar();

            //Define o redirecionamento
            if (isset($post['id']) && $post['id']) {
                $this->redirect()->toRoute('navegacao', array('controller' => $controller, 'action' => 'index'));
            } else {
                $this->redirect()->toRoute('navegacao', array('controller' => $controller, 'action' => 'cadastroperiodoletivodetalhe', 'id' => Cript::enc($id_periodo_letivo)));
            }

            return $id_periodo_letivo;

        } catch (\Exception $e) {

            $this->setPost($post);
            $this->addErrorMessage($e->getMessage());
            $this->redirect()->toRoute('navegacao', array('controller' => $controller, 'action' => 'cadastro'));
            return false;
        }
    }

    public function excluirAction()
    {
        return parent::excluir($this->service, $this->form);
    }

    public function cadastroAction()
    {
        return parent::cadastro($this->service, $this->form);
    }

    public function cadastroperiodoletivodetalheAction()
    {
        //recuperar o id do Periodo Letivo
        $id_periodo_letivo = Cript::dec($this->params('id'));

        #xd($this->params('id'));
        $periodo_letivo = new \PeriodoLetivo\Service\PeriodoLetivoService();
        $dadosPeriodoLetivo = $periodo_letivo->buscar($id_periodo_letivo);

        $dadosView = [
            'service' => new \DetalhePeriodoLetivo\Service\DetalhePeriodoLetivoService(),
            'form' => new \DetalhePeriodoLetivo\Form\DetalhePeriodoLetivoForm(),
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
            $id_periodo_letivo = $this->params()->fromPost('id');
            $dt_encontro = $this->params()->fromPost('dt_encontro');

            $dt_encontro = Data::converterDataHoraBrazil2BancoMySQL($dt_encontro);
            $detalhe_periodo_letivo = new \DetalhePeriodoLetivo\Service\DetalhePeriodoLetivoService();

            $id_inserido = $detalhe_periodo_letivo->getTable()->salvar(array('id_periodo_letivo' => $id_periodo_letivo, 'dt_encontro' => $dt_encontro), null);
            $valuesJson = new JsonModel(array('id_inserido' => $id_inserido, 'sucesso' => true, 'dt_encontro' => $dt_encontro));

            return $valuesJson;
        }
    }

    public function detalhePaginationAction()
    {
        $filter = $this->getFilterPage();

        $id_periodo_letivo = $this->params()->fromPost('id_periodo_letivo');
        $camposFilter = [
            '0' => [
                //'filter' => "periodoletivodetalhe.nm_sacramento LIKE ?",
            ],

        ];

        $paginator = $this->service->getPeriodoLetivoDetalhePaginator($id_periodo_letivo, $filter, $camposFilter);

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
            'id_periodo_letivo' => $id_periodo_letivo,
            'atributos' => array()
        ]);

        return $viewModel->setTerminal(TRUE);
    }

} 