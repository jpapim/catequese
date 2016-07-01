<?php
/**
 * Created by PhpStorm.
 * User: IGOR
 * Date: 30/06/2016
 * Time: 22:25
 */

namespace Formacao\Controller;
use DetalheFormacao;
use Estrutura\Controller\AbstractCrudController;
use Estrutura\Helpers\Cript;
use Formacao\Service\FormacaoService;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

class FormacaoController extends  AbstractCrudController {

    /**
     * @var \Formacao\Service\Formacao
     */
    protected  $service;
    /**
     * @var \Formacao\Form\Formacao
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
                'filter' => "formacao.id_formacao  LIKE ?"
            ],
            '1'=>[
                'filter' => "formacao.nm_formacao  LIKE ?"
            ],

        ];
        $paginator = $this->service->getFormacaoPaginator($filter, $camposFilter);

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

    public function cadastrodetalheformacaoAction()
    {
        //recuperar o id do Modulo Formacao
        $id_formacao = Cript::dec($this->params('id') );
        #xd($this->params('id'));
        $formacao = new FormacaoService();
        $dadosFormacao = $formacao->buscar($id_formacao);

        $dadosView = [
            'service' => new \DetalheFormacao\Service\DetalheFormacaoService(),
            'form' => new \DetalheFormacao\Form\DetalheFormacaoForm(),
            'controller' => $this->params('controller'),
            'atributos' => array(),
            'id_formacao' => $id_formacao,
            'dadosFormacao' => $dadosFormacao,
        ];

        return new ViewModel($dadosView);
        //}
    }

    public function adicionardetalheformacaoAction()
    {
        //Se for a chamada Ajax
        if ($this->getRequest()->isPost()) {
            $id_formacao = $this->params()->fromPost('id');
            $ds_detalhe_formacao = $this->params()->fromPost('ds_detalhe_formacao');
            $detalhe_formacao = new DetalheFormacaoService();

            $id_inserido = $detalhe_formacao->getTable()->salvar(array('id_formacao'=>$id_formacao, 'ds_detalhe_formacao'=>$ds_detalhe_formacao), null);
            $valuesJson = new JsonModel( array('id_inserido'=>$id_inserido, 'sucesso'=>true, 'ds_detalhe_formacao'=>$ds_detalhe_formacao) );

            return $valuesJson;
        }
    }

    public function detalhePaginationAction()
    {
        $filter = $this->getFilterPage();

        $id_formacao = $this->params()->fromPost('id_formacao');
        $camposFilter = [
            '0' => [
                //'filter' => "periodoletivodetalhe.nm_sacramento LIKE ?",
            ],

        ];

        $paginator = $this->service->getFormacaoPaginator( $filter, $camposFilter);

        $paginator->setItemCountPerPage($paginator->getTotalItemCount());

        $countPerPage = $this->getCountPerPage(
            current(\Estrutura\Helpers\Pagination::getCountPerPage($paginator->getTotalItemCount()))
        );

        $paginator->setItemCountPerPage($this->getCountPerPage(
            current(\Estrutura\Helpers\Pagination::getCountPerPage($paginator->getTotalItemCount()))
        ))->setCurrentPageNumber($this->getCurrentPage());

        $viewModel = new ViewModel([
            'service' => $this->service,
            'form' => new \DetalheFormacao\Form\DetalheFormacaoForm(),
            'paginator' => $paginator,
            'filter' => $filter,
            'countPerPage' => $countPerPage,
            'camposFilter' => $camposFilter,
            'controller' => $this->params('controller'),
            'id_formacao'=>$id_formacao,
            'atributos' => array()
        ]);

        return $viewModel->setTerminal(TRUE);
    }


} 