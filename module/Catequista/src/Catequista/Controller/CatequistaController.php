<?php

namespace Catequista\Controller;

use Email\Service\EmailService;
use Estrutura\Controller\AbstractCrudController;
use Estrutura\Helpers\Cript;
use Estrutura\Helpers\Data;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

class CatequistaController extends AbstractCrudController
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
//http://igorrocha.com.br/tutorial-zf2-parte-9-paginacao-busca-e-listagem/4/


        return new ViewModel([
            'service' => $this->service,
            'form' => $this->form,
            'controller' => $this->params('controller'),
            'atributos' => array()
        ]);
    }

    public function gravarAction()
    {

// FORMATANDO AS DATAS RECEBIDAS     
        $dateNascimento = \DateTime::createFromFormat('d/m/Y', $this->getRequest()->getPost()->get('dt_nascimento'));
        $dateIngresso = \DateTime::createFromFormat('d/m/Y', $this->getRequest()->getPost()->get('dt_ingresso'));


###########################- GRAVANDO EMAIL -#######################################################################

        //verificando email
        $this->addSuccessMessage('Endereco  table Inserido/Alterado com sucesso');

        $emailService = $this->getServiceLocator()->get('\Email\Service\EmailService');

        $emailService->setEmEmail(trim($this->getRequest()->getPost()->get('em_email')));
        $emailService->setIdSituacao(trim($this->getRequest()->getPost()->get('id_situacao')));

        if ($emailService->filtrarObjeto()->count()) {

            $this->addErrorMessage('Email já cadastrado. Faça seu login.');
            $this->redirect()->toRoute('cadastro', array('id' => $this->getRequest()->getPost()->get('id_usuario_pai')));
            return FALSE;
        }
//gravando email
        $resultEmail = parent::gravar(
            $this->getServiceLocator()->get('\Email\Service\EmailService'), new \Email\Form\EmailForm()
        );


        //##############################################################################################
        //GRAVANDO CATEQUISTA
        if ($resultEmail) {
            $this->addSuccessMessage('Email tabela Inserido/Alterado com sucesso');
            // INSERINDO CAMPOS COM FKS DA TABELA CATEQUISTA
            $catequistaService = $this->getServiceLocator()->get('\Catequista\Service\CatequistaService');
            $catequistaService->setIdUsuario(trim($this->getRequest()->getPost()->get('id_usuario')));
            $catequistaService->setIdEndereco(trim($this->getRequest()->getPost()->get('id_endereco')));
            $catequistaService->setIdSexo(trim($this->getRequest()->getPost()->get('id_sexo')));
            $catequistaService->setIdEmail(trim($this->getRequest()->getPost()->get('id_email', $resultEmail)));
            $catequistaService->setIdSituacao(trim($this->getRequest()->getPost()->get('id_situacao', $resultEmail)));

            ///INSERINDO CAMPOS DA TABELA CATEQUISTA
            $catequistaService->setNmCatequista(trim($this->getRequest()->getPost()->get('nm_catequista')));
            $catequistaService->setNrCatequista(trim($this->getRequest()->getPost()->get('nr_matricula')));
            $catequistaService->setDtNascimento(trim($this->getRequest()->getPost()->get('dt_nascimento', $dateNascimento->format('Y-m-d'))));
            $catequistaService->setDtIngresso(trim($this->getRequest()->getPost()->get('dt_ingresso', $dateNascimento->format('Y-m-d'))));
            $catequistaService->setTxObservacao(trim($this->getRequest()->getPost()->get('tx_observacao')));
            $catequistaService->setDsSituacao(trim($this->getRequest()->getPost()->get('ds_situacao')));
            $catequistaService->setCsCoordenador(trim($this->getRequest()->getPost()->get('cs_coordenador')));

            $resultCatequista = parent::gravar(
                $this->getServiceLocator()->get('\Catequista\Service\CatequistaService'), new \Catequista\Form\CatequistaForm()
            );
            $this->addSuccessMessage('Registro Inserido/Alterado com sucesso');

        }
        if ($resultCatequista) {
            $this->addSuccessMessage('Todos Registro Inserido/Alterado com sucesso');


        }


    }

    public function cadastroAction()
    { // funnção alterar
        return parent::cadastro($this->service, $this->form);
    }

    public function excluirAction()
    {
        return parent::excluir($this->service, $this->form);
    }
}