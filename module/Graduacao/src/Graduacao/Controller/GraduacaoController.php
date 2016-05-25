<?php

namespace Graduacao\Controller;

use Estrutura\Controller\AbstractCrudController;

use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\ArrayAdapter;
use Zend\View\Model\ViewModel;

class GraduacaoController extends AbstractCrudController
{
    /**
     * @var \Graduacao\Service\Graduacao
     */
    protected $service;

    /**
     * @var \Graduacao\Form\Graduacao
     */
    protected $form;

    public function __construct(){
        parent::init();
    }

    public function indexAction(){
        $dadosView = [
            'service' => $this->service,
            'form' => $this->form,
            'lista' => $this->service->filtrarObjeto(),
            'controller' => $this->params('controller'),
            'atributos' => array()
        ];
        return new ViewModel($dadosView);
        //return parent::index($this->service, $this->form);
    }


    public function indexPaginationAction()
    {
        //http://igorrocha.com.br/tutorial-zf2-parte-9-paginacao-busca-e-listagem/4/

        $filter = $this->getFilterPage();

        $camposFilter = [
            '0' => [
                'filter' => "arte_marcial.nm_arte_marcial LIKE ?",
            ],
            '1' => [
                'filter' => "estilos.nm_estilo LIKE ?",
            ],
            '2' => [
                'filter' => "graduacoes.nm_graduacao LIKE ?",
            ],
            '3' => NULL,
        ];


        $graduacaoPaginator = $this->service->getGraduacaoPaginator($filter, $camposFilter);

        $graduacaoPaginator->setItemCountPerPage($graduacaoPaginator->getTotalItemCount());

        $countPerPage = $this->getCountPerPage(
            current(\Estrutura\Helpers\Pagination::getCountPerPage($graduacaoPaginator->getTotalItemCount()))
        );

        $graduacaoPaginator->setItemCountPerPage($this->getCountPerPage(
            current(\Estrutura\Helpers\Pagination::getCountPerPage($graduacaoPaginator->getTotalItemCount()))
        ))->setCurrentPageNumber($this->getCurrentPage());

        $viewModel = new ViewModel([
            'service' => $this->service,
            'form' => $this->form,
            'paginator' => $graduacaoPaginator,
            'filter' => $filter,
            'countPerPage' => $countPerPage,
            'camposFilter' => $camposFilter,
            'controller' => $this->params('controller'),
            'atributos' => array()
        ]);

        return $viewModel->setTerminal(TRUE);
    }




    public function gravarAction() {
        #Alysson
        $controller = $this->params('controller');
        $this->addSuccessMessage('Registro Alterado com sucesso');
        $this->redirect()->toRoute('navegacao', array('controller' => $controller, 'action' => 'index-pagination'));
        return parent::gravar($this->service, $this->form);
    }

    public function cadastroAction(){
        return parent::cadastro($this->service, $this->form);
    }

    public function excluirAction()
    {
        return parent::excluir($this->service, $this->form);
    }

    
}
