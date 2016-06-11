<?php

namespace Check\Controller;

use Estrutura\Controller\AbstractCrudController;
use Zend\View\Model\ViewModel;

use Estrutura\Helpers\Cript;

class CheckController extends AbstractCrudController
{
    /**
     * @var \Check\Service\Check
     */
    protected $service;

    /**
     * @var \Check\Form\Check
     */
    protected $form;

    public function __construct(){
        parent::init();
    }

    public function indexAction()
    {
        return parent::index($this->service, $this->form);
    }

    /*
    public function gravarAction(){
        #Alysson
        $this->addSuccessMessage('Registro Inserido/Alterado com sucesso');
        $this->redirect()->toRoute('navegacao', array('controller' => 'check-check', 'action' => 'index'));
        #xd($this->form);
        return parent::gravar($this->service, $this->form);
    }*/

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
            #################################################################
            # Inicio da Customiza�ao dos Valores antes de gravar no banco
            #$academia = new \Academia\Service\AcademiaService();
            #$arrCidade = $academia->getIdAcademiaPorNomeToArray($post['id_academia']);
            #$post['id_academia'] = $arrCidade['id_academia'];

            #$cidade = new \Cidade\Service\CidadeService();
            #$arrCidade = $cidade->getIdCidadePorNomeToArray($post['id_cidade']);
            #$post['id_cidade'] = $arrCidade['id_cidade'];

            #$post['dt_nascimento'] = Data::converterDataHoraBrazil2BancoMySQL($post['dt_nascimento']);
            # Fim da Customiza�ao dos Valores antes de gravar no banco
            #################################################################

            xd($post);

            $form->setData($post);

            if (!$form->isValid()) {
                $this->addValidateMessages($form);
                $this->setPost($post);
                $this->redirect()->toRoute('navegacao', array('controller' => $controller, 'action' => 'cadastro'));
                return false;
            }

            $service->exchangeArray($form->getData());
            $this->addSuccessMessage('Registro Alterado com sucesso');
            $this->redirect()->toRoute('navegacao', array('controller' => $controller, 'action' => 'index'));
            return $service->salvar();

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

    public function indexPaginationAction()
    {
        #http://igorrocha.com.br/tutorial-zf2-parte-9-paginacao-busca-e-listagem/4/

        $filter = $this->getFilterPage();

        $camposFilter = [
            '0' => [
                'filter' => "estado.nm_estado LIKE ?",
            ],
            '1' => NULL,
        ];

        $paginator = $this->service->getChecksPaginator($filter, $camposFilter);
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

}
