<?php

namespace Catequista\Controller;

use Estrutura\Controller\AbstractCrudController;
use Estrutura\Helpers\Cript;
use Estrutura\Helpers\Data;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

class CatequistaController extends AbstractCrudController
{
   
    protected $service;

    
    protected $form;

     public function __construct(){
        parent::init();
     }

 
      public function indexAction()
             {
 return parent::index($this->service, $this->form);        
//http://igorrocha.com.br/tutorial-zf2-parte-9-paginacao-busca-e-listagem/4/
      
    
        return new ViewModel([
            'service' => $this->service,
            'form' => $this->form,
            'controller' => $this->params('controller'),
            'atributos' => array()
        ]);
    }
    
    public function gravarAction(){
   
// FORMATANDO AS DATAS RECEBIDAS     
$dateNascimento = \DateTime::createFromFormat('d/m/Y', $this->getRequest()->getPost()->get('dt_nascimento'));
$dateIngresso = \DateTime::createFromFormat('d/m/Y', $this->getRequest()->getPost()->get('dt_ingresso'));


###########################- GRAVANDO EMAIL -#######################################################################
     
      $form = new \Catequista\Form\CatequistaForm();
        /* @var $emailService \Email\Service\EmailService */
        $emailService = $this->getServiceLocator()->get('\Email\Service\EmailService');
        $emailService->setEmEmail(trim($this->getRequest()->getPost()->get('em_email')));
        $emailService->setEmEmail(trim($this->getRequest()->getPost()->get('id_situacao')));
        #Alysson - Verifica se já existe este emaill cadastrado para um usuário
        if ($emailService->filtrarObjeto()->count()) {
            $this->addErrorMessage('Email já cadastrado. Faça seu login.');
           
            return FALSE;
        }
           $resultEmail = parent::gravar(
                $this->getServiceLocator()->get('\Email\Service\EmailService'), new \Email\Form\EmailForm()
            );
      //##############################################################################################
        //GRAVANDO CATEQUISTA

    if($resultEmail){
     $this->addSuccessMessage('Email tabela Inserido/Alterado com sucesso');
  // INSERINDO CAMPOS COM FKS DA TABELA CATEQUISTA 
       $this->getRequest()->getPost()->set('id_usuario', $this->getRequest()->getPost()->get('id_usuario'));
       $this->getRequest()->getPost()->set('id_endereco', $this->getRequest()->getPost()->get('id_endereco'));
       $this->getRequest()->getPost()->set('id_sexo', $this->getRequest()->getPost()->get('id_sexo'));
        
        $this->getRequest()->getPost()->set('id_email', $resultEmail); 
        $this->getRequest()->getPost()->set('id_situacao', $this->getRequest()->getPost()->get('id_situacao'));
        
        ///INSERINDO CAMPOS DA TABELA CATEQUISTA
        $this->getRequest()->getPost()->set('nm_catequista', $this->getRequest()->getPost()->get('nm_catequista'));
        $this->getRequest()->getPost()->set('nr_matricula', $this->getRequest()->getPost()->get('nr_matricula'));
        $this->getRequest()->getPost()->set('dt_nascimento', $dateNascimento->format('Y-m-d'));
        $this->getRequest()->getPost()->set('dt_ingresso', $dateIngresso->format('Y-m-d'));
        $this->getRequest()->getPost()->set('tx_observacao', $this->getRequest()->getPost()->get('tx_observacao'));
        $this->getRequest()->getPost()->set('ds_situacao', $this->getRequest()->getPost()->get('ds_situacao'));
        $this->getRequest()->getPost()->set('cs_coodenador', $this->getRequest()->getPost()->get('cs_coordenador'));
        
        //GRAVANDO CAMPOS CATEQUISTA,PARAMETRO (FORMULARIO ALTERNATIVO SEM COMBOS)
           parent::gravar(
                            $this->getServiceLocator()->get('\Catequista\Service\CatequistaService'), new \Catequista\Form\CatequistaDetalheForm()
            );
    
    $this->addSuccessMessage('Registro Inserido/Alterado com sucesso');
    $this->redirect()->toRoute('navegacao', array('controller' => 'catequista-catequista', 'action' => 'index'));
  
    }}

  public function cadastroAction()
    { // funnção alterar
        return parent::cadastro($this->service, $this->form);
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
            '0' => [
                'filter' => "catequista.nm_catequista LIKE ?",
            ],
              '1' => [
                 'filter' => "catequista.nr_matricula LIKE ?",
            ],
            
              '2' => [
                 'filter' => "catequista.dt_nascimento LIKE ?",
            ],
            
              '3' => [
                'filter' => "catequista.dt_ingresso LIKE ?",
            ],
            
                '4' => [
                'filter' => "catequista.tx_observacao LIKE ?",
            ],

                '5' => [
                'filter' => "catequista.ds_situacao LIKE ?",
            ],
            
                '6' => [
                'filter' => "catequista.cs_coordenador LIKE ?",
            ],
            
            
        ];
        
        $paginator = $this->service->getCatequistaPaginator($filter, $camposFilter);

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
