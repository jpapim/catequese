<?php

namespace EstadoCivil\Controller;

use Estrutura\Controller\AbstractCrudController;
use Zend\View\Model\ViewModel;

class EstadoCivilController extends AbstractCrudController
{
    /**
     * @var \EstadoCivil\Service\EstadoCivil
     */
    protected $service;

    /**
     * @var \EstadoCivil\Form\EstadoCivil
     */
    protected $form;

    public function __construct()
    {
        parent::init();
    }

    public function indexAction()
    {
        return parent::index($this->service, $this->form);
    }

    public function indexPaginationAction()
    {// funcao paginacao

        $filter = $this->getFilterPage();
        $camposFilter = [
            '0' => NULL,
            '1' => [
                'filter' => "estado_civil.nm_estado_civil LIKE ?",
            ],
            '2' => NULL,

        ];

        $paginator = $this->service->getEstadoCivilPaginator($filter, $camposFilter);
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
    {
        return parent::cadastro($this->service, $this->form);
    }

    public function excluirAction()
    {
        return parent::excluir($this->service, $this->form);
    }
}
