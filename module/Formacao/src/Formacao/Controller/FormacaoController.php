<?php
/**
 * Created by PhpStorm.
 * User: IGOR
 * Date: 30/06/2016
 * Time: 22:25
 */

namespace Formacao\Controller;
use DetalheFormacao;
use DetalheFormacao\Service\DetalheFormacaoService;
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
            '0' => NULL,
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

    /*public function gravarAction(){
        $controller = $this->params('controller');
        $this->addSuccessMessage('Registro Alterado com sucesso');
        $this->redirect()->toRoute('navegacao', array('controller' => $controller, 'action' => 'index'));
        return parent::gravar($this->service, $this->form);
    }*/

    public function gravarAction()
    {
        try {
            $controller = $this->params('controller');
            $request = $this->getRequest();
            $service = $this->service;
            $form = $this->form;

            if (!$request->isPost()) {
                throw new \Exception('Dados Inv�lidos');
            }

            $post = \Estrutura\Helpers\Utilities::arrayMapArray('trim', $request->getPost()->toArray());

            $files = $request->getFiles();
            $upload = $this->uploadFile($files);

            $post = array_merge($post, $upload);

            if (isset($post['id']) && $post['id']) {
                $post['id'] = Cript::dec($post['id']);
            }

            $form->setData($post);

            if (!$form->isValid()) {
                $this->addValidateMessages($form);
                $this->setPost($post);
                $this->redirect()->toRoute('navegacao', array('controller' => $controller, 'action' => 'cadastro'));
                return false;
            }
            $service->exchangeArray($form->getData());
            $this->addSuccessMessage('Cadastro Realizado com sucesso');
            $id_formacao = $service->salvar();

            //Define o redirecionamento
            if (isset($post['id']) && $post['id']) {
                $this->redirect()->toRoute('navegacao', array('controller' => $controller, 'action' => 'index'));
            } else {
                $this->redirect()->toRoute('navegacao', array('controller' => $controller, 'action' => 'cadastrodetalheformacao', 'id' => Cript::enc($id_formacao)));
            }

            return $id_formacao;

        } catch (\Exception $e) {
            $this->setPost($post);
            $this->addErrorMessage($e->getMessage());
            $this->redirect()->toRoute('navegacao', array('controller' => $controller, 'action' => 'cadastro'));
            return false;
        }
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
        #xd($id_formacao);
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
            $id_formacao= $this->params()->fromPost('id');
            $ds_detalhe_formacao = $this->params()->fromPost('ds_detalhe_formacao');
            #xd($id_formacao);
            $detalhe_formacao = new DetalheFormacaoService();

            $id_inserido = $detalhe_formacao->getTable()->salvar(array('id_formacao'=>$id_formacao,'ds_detalhe_formacao'=>$ds_detalhe_formacao), null);
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
             //   'filter' => "periodoletivodetalhe.nm_sacramento LIKE ?",
            ],

        ];

        $paginator = $this->service->getFormacaoDetalhePaginator( $id_formacao, $filter, $camposFilter);

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
