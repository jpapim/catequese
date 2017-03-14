<?php


namespace Profissao\Controller;

use Estrutura\Controller\AbstractCrudController;
use Estrutura\Helpers\Pagination;
use Profissao\Form\ProfissaoForm;
use Profissao\Service\ProfissaoService;
use Zend\View\Model\ViewModel;

class ProfissaoController extends  AbstractCrudController{

    /** @var  ProfissaoService*/
    protected $service;
    /** @var  ProfissaoForm*/
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

        $camposFilter =[
            '0' => NULL,
            '1' => [
                'filter' => "profissao.nm_profissao  LIKE ?"
            ],
        ];


        $paginator = $this->service->getProfissaoPaginator($filter, $camposFilter);
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

         $controller =  $this->params('controller');
        #$id_profissao = Cript::dec($this->getRequest()->getPost()->get('id'));

        $pos = $this->getRequest()->getPost()->toArray();
        #$arrc = $this->service->buscar(Cript::dec($pos['id']))->toArray();

        
        /*@var $emailService \Email\Service\EmailService */
            $Profissao = $this->getServiceLocator()->get('\Profissao\Service\ProfissaoService');
            $Profissao->setNmProfissao(trim($this->getRequest()->getPost()->get('nm_profissao')));
            if ($Profissao->filtrarObjeto()->count()) {

                if ($Profissao->filtrarObjeto()->count()) {
               
                
                $this->addErrorMessage('Profissão já cadastrada');
                $this->redirect()->toRoute('navegacao', array('controller' => $controller, 'action' => 'index'));
               return FALSE;
            }}
           
              $this->getRequest()->getPost()->set('nm_profissao', $this->getRequest()->getPost()->get('nm_profissao'));
             $resultLogin = parent::gravar(
                                   $this->getServiceLocator()->get('\Profissao\Service\ProfissaoService'), new \Profissao\Form\ProfissaoForm()
                   ); 
                    $this->addSuccessMessage(' Profissão cadastrada com sucesso.');
                    $this->redirect()->toRoute('navegacao', array('controller' => 'profissao-profissao', 'action' => 'index'));
      
    }

    public function cadastroAction()
    { //função de alterar
        return parent::cadastro($this->service, $this->form);
    }

    public function excluirAction()
    {
        return parent::excluir($this->service, $this->form);
    }

} 