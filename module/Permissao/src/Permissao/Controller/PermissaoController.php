<?php

namespace Permissao\Controller;

use Estrutura\Controller\AbstractCrudController;
use PerfilControllerAction\Service\PerfilControllerActionService;
use Zend\View\Model\ViewModel;

use Estrutura\Helpers\Cript;

class PermissaoController extends AbstractCrudController
{
    /**
     * @var \Permissao\Service\Permissao
     */
    protected $service;

    /**
     * @var \Permissao\Form\Permissao
     */
    protected $form;

    public function __construct(){
        parent::init();
    }

    public function indexAction()
    {
        return parent::index($this->service, $this->form);
    }

    /**
     * @return bool
     */
    public function gravarAction() {
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

            #xd($post);
            $form->setData($post);

            if (!$form->isValid()) {
                $this->addValidateMessages($form);
                $this->setPost($post);
                $this->redirect()->toRoute('navegacao', array('controller' => $controller, 'action' => 'cadastro'));
                return false;
            }

            #Excluir todos os registros com o mesmo id_controller e id_perfil passados no objeto, para depois regravar as permissoes
            $obPerfilControllerActionService = new \PerfilControllerAction\Service\PerfilControllerActionService();
            $obPerfilControllerActionService->setIdController($post['id_modulo']);
            $obPerfilControllerActionService->setIdPerfil($post['id_perfil']);
            $obPerfilControllerActionService->excluir();

            #Mensagem retornada Quando houver sucesso na operaçao
            $this->addSuccessMessage('Permissão concedida com Sucesso para Açoes Selecionadas.');
            $this->redirect()->toRoute('permissao', array('controller' => $controller, 'action' => 'cadastro', 'aux'=>Cript::enc($post['id_perfil']), 'aux2'=> Cript::enc($post['id_modulo']) ));
            $arrIdAction = $post['id_action'];
            foreach($arrIdAction as $id_action){
                #Carrega O array Post com os dados a serem salvos e aproveita a  validação do formulario
                $this->getRequest()->getPost()->set('id_perfil', $post['id_perfil']);
                $this->getRequest()->getPost()->set('id_controller', $post['id_modulo']);
                $this->getRequest()->getPost()->set('id_action', $id_action);
                #Chamo o metodo para gravar os dados na tabela.
                parent::gravar(
                    $this->getServiceLocator()->get('\PerfilControllerAction\Service\PerfilControllerActionService'), new \PerfilControllerAction\Form\PerfilControllerActionForm()
                );
            }
            return true;

        } catch (\Exception $e) {

            $this->setPost($post);
            $this->addErrorMessage($e->getMessage());
            $this->redirect()->toRoute('navegacao', array('controller' => $controller, 'action' => 'cadastro'));
            return false;
        }
    }

    public function cadastroAction()
    {
        //recuperar o id do Periodo Letivo
        $id_perfil = Cript::dec($this->params('aux') );
        $id_controller = Cript::dec($this->params('aux2') );

        #Recupera os IDs utilizados para Gravar e carrega os Dados Iguais, Permanecendo na tela.
        $post['id_perfil'] = $id_perfil;
        $post['id_modulo'] = $id_controller;

        $this->form->setData($post);

        $dadosView = [
            'service' => $this->service,
            'form' => $this->form,
            'controller' => $this->params('controller'),
            'atributos' => array(),
            'id_perfil' => $id_perfil,
            'id_controller' => $id_controller,
        ];

        return new ViewModel($dadosView);

    }

    public function excluirAction()
    {
        return parent::excluir($this->service, $this->form);
    }

    public function indexPaginationAction()
    {

        $filter = $this->getFilterPage();

        $camposFilter = [
            '0' => [
                'filter' => "perfil_controller_action.id_controller = ?",
            ],
            '1' => NULL,
        ];

        $paginator = $this->service->getPermissaoPaginator($filter, $camposFilter);
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

    public function listarPermissoesAcoesAction()
    {
        //Se for a chamada Ajax
        if ($this->getRequest()->isPost()) {
            $id_controller_ajax = $this->params()->fromPost('id_controller');
            $id_perfil_ajax = $this->params()->fromPost('id_perfil');

            #Carrego aqui Todos Os Actions existentes na Tabela de Controle por Controller e Perfil
            $obPerfilControllerAction = new \PerfilControllerAction\Service\PerfilControllerActionService();
            $colecaoActionsControle = $obPerfilControllerAction->retornaTodosPorControllerEPerfil($id_controller_ajax, $id_perfil_ajax);
            $arrActions = [];
            foreach ($colecaoActionsControle as $key => $ob_action_controle) {
                $arrActions[] = $ob_action_controle->getIdAction();
            }

            #Preenche um Array de Opçoes a ser passado para o Formulario
            $options = array();
            $options['acoes'] = $arrActions;
            $options['id_controller'] = $id_controller_ajax;
            $options['id_perfil'] = $id_perfil_ajax;

            $form = new \Permissao\Form\PermissaoForm($options);

            $viewModel = new ViewModel([
                'service' => $this->service,
                'form' => $form,
                'controller' => $this->params('controller'),
                'atributos' => array()
            ]);

            return $viewModel->setTerminal(TRUE);
        }


    }

}
