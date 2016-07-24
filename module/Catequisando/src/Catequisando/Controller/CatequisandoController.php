<?php
/**
 * Created by PhpStorm.
 * User: IGOR
 * Date: 14/07/2016
 * Time: 16:46
 */

namespace Catequisando\Controller;


use Catequisando\Form\CatequisandoForm;
use Catequisando\Service\CatequisandoService;
use Estrutura\Controller\AbstractCrudController;
use Estrutura\Helpers\Cript;
use Estrutura\Helpers\Data;
use Zend\View\Model\ViewModel;


class CatequisandoController extends  AbstractCrudController{

    /**@var CatequisandoService     */
     protected $service;

    /**@var CatequisandoForm     */
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

        ];


        $paginator = $this->service->getCatequisandoPaginator($filter, $camposFilter);

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

        /* @var $emailService \Email\Service\EmailService */
        $emailService = $this->getServiceLocator()->get('Email\Service\EmailService');
        $emailService->setEmEmail(trim($this->getRequest()->getPost()->get('em_email')));

        if ($emailService->filtrarObjeto()->count()) {

            $this->addErrorMessage('Email já cadastrado. Faça seu login.');
            $this->redirect()->toRoute('navegacao', array('controller' => 'catequisando', 'action' => 'index'));
            return FALSE;
        }

        $dateNascimento = \DateTime::createFromFormat('Y-m-d', $this->getRequest()->getPost()->get('dt_nascimento'));

        # Grava os dados do Endereco e retorna o ID do Endereco
        $resultEndereco = parent::gravar(
            $this->getServiceLocator()->get('\Endereco\Service\EnderecoService'), new \Endereco\Form\EnderecoForm()
        );
        if($resultEndereco){
            $this->addSuccessMessage('Parabéns! Endereço cadastro com sucesso.');
        }

        # Realizando Tratamento do Telefone Residencial
        $this->getRequest()->getPost()->set('nr_ddd_telefone', \Estrutura\Helpers\Telefone::getDDD($this->getRequest()->getPost()->get('id_telefone_residencial')));
        $this->getRequest()->getPost()->set('nr_telefone', \Estrutura\Helpers\Telefone::getTelefone($this->getRequest()->getPost()->get('id_telefone_residencial')));
        $this->getRequest()->getPost()->set('id_tipo_telefone', $this->getConfigList()['tipo_telefone_residencial']);
        $this->getRequest()->getPost()->set('id_situacao', $this->getConfigList()['situacao_ativo']);

        $resultTelefoneResidencial = parent::gravar(
            $this->getServiceLocator()->get('\Telefone\Service\TelefoneService'), new \Telefone\Form\TelefoneForm()
        );

        # REalizando Tratamento do  Telefone Celular
        $this->getRequest()->getPost()->set('nr_ddd_telefone', \Estrutura\Helpers\Telefone::getDDD($this->getRequest()->getPost()->get('id_telefone_celular')));
        $this->getRequest()->getPost()->set('nr_telefone', \Estrutura\Helpers\Telefone::getTelefone($this->getRequest()->getPost()->get('id_telefone_celular')));
        $this->getRequest()->getPost()->set('id_tipo_telefone', $this->getConfigList()['tipo_telefone_celular']);
        $this->getRequest()->getPost()->set('id_situacao', $this->getConfigList()['situacao_ativo']);

        $resultTelefoneCelular = parent::gravar(
            $this->getServiceLocator()->get('\Telefone\Service\TelefoneService'), new \Telefone\Form\TelefoneForm()
        );


        if ($resultTelefoneResidencial && $resultTelefoneCelular) {
            $this->addSuccessMessage('Parabéns! Telefones cadastros com sucesso.');
        }


        # Gravando email e retornando o ID do Email
            $resultEmail = parent::gravar(
                $this->getServiceLocator()->get('\Email\Service\EmailService'), new \Email\Form\EmailForm()
            );

            if ($resultEmail) {
                    $this->addSuccessMessage('Parabéns! Email cadastrado com sucesso.');
            }

        # Tratando informações do array Sacramento
        $sacramento = $this->getRequest()->getPost()->get('sacramento');


        #Tratando informações do array etapa
        $etapa = $this->getRequest()->getPost()->get('etapa');

        $this->getRequest()->getPost()->set('id_endereco', $resultEndereco);
        $this->getRequest()->getPost()->set('dt_nascimento', $dateNascimento);
        $this->getRequest()->getPost()->set('id_telefone_residencial', $resultTelefoneResidencial);
        $this->getRequest()->getPost()->set('id_telefone_celular', $resultTelefoneCelular);
        $this->getRequest()->getPost()->set('id_email', $resultEmail);
       # $this->getRequest()->getPost()->set('id_tipo_usuario', $this->getConfigList()['tipo_usuario_aluno']);
        $this->getRequest()->getPost()->set('id_situacao', $this->getConfigList()['situacao_ativo']);

        $resultCatequisando= parent::gravar(
            $this->getServiceLocator()->get('\Catequisando\Service\CatequisandoService'), new \Catequisando\Form\CatequisandoForm());

        if ($resultCatequisando) {
            $this->addSuccessMessage('Parabéns! Catequizando cadastrado com sucesso.');
        }
        $this->redirect()->toRoute('navegacao', array('controller' => 'catequisando', 'action' => 'index'));
    }

    public function cadastroAction()
    { // funn��o alterar
        return parent::cadastro($this->service, $this->form);
    }

    public function excluirAction()
    {
        return parent::excluir($this->service, $this->form);
    }


} 