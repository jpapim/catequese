<?php

namespace ResponsavelCatequizando\Controller;

use Estrutura\Controller\AbstractCrudController;
use Estrutura\Helpers\Cript;
use Estrutura\Helpers\Data;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

class ResponsavelCatequizandoController extends AbstractCrudController
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
                'filter' => "responsavel_catequizando.id_responsavel_catequizando LIKE ?",
            ],
            '1' => [
                'filter' => "catequizando.nm_catequizando LIKE ?",
            ],
            '2' => [
                'filter' => "responsavel.nm_responsavel LIKE ?",
            ],

            '3' => [
                'filter' => "grau_parentesco.nm_grau_parentesco LIKE ?",
            ],
            '4' => NULL,

        ];

        $paginator = $this->service->getResponsavelCatequizandoPaginator($filter, $camposFilter);

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
    { // funnção alterar
        return parent::cadastro($this->service, $this->form);
    }

    public function excluirAction()
    {
        return parent::excluir($this->service, $this->form);
    }

    //    public function gravarAction()
//    {
//
//        //##############################################################################################
//        //GRAVANDO RESPONSAVEL
//
//        // INSERINDO CAMPOS COM FKS DA TABELA
//        $ResponsavelCatequizandoService = $this->getServiceLocator()->get('\ResponsavelCatequizando\Service\ResponsavelCatequizandoService');
//        //  $catequistaService->setIdResponsavel(trim($this->getRequest()->getPost()->get('id_responsavel')));
//        //  $catequistaService->setIdCatequizando(trim($this->getRequest()->getPost()->get('id_catequizando')));
//        $catequistaService->setIdGrauParentesco(trim($this->getRequest()->getPost()->get('id_grau_parentesco')));
//
//        parent::gravar(
//            $this->getServiceLocator()->get('\ResponsavelCatequizando\Service\ResponsavelCatequizandoService'), new \ResponsavelCatequizando\Form\ResponsavelCatequizandoForm()
//        );
//
//        $this->addSuccessMessage('Registro Inserido/Alterado com sucesso');
//        $this->redirect()->toRoute('navegacao', array('controller' => 'responsavel_catequizando-responsavelcatequizando', 'action' => 'index'));
//
//    }
    

}




    