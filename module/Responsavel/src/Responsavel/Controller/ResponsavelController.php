<?php

namespace Responsavel\Controller;

use Estrutura\Controller\AbstractCrudController;
use Estrutura\Helpers\Cript;
use Estrutura\Helpers\Data;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

class ResponsavelController extends AbstractCrudController
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

        //GRAVANDO TABELA EMAIL
        $form = new \Responsavel\Form\ResponsavelForm();
        /* @var $emailService \Email\Service\EmailService */
        $emailService = $this->getServiceLocator()->get('\Email\Service\EmailService');
        $emailService->setEmEmail(trim($this->getRequest()->getPost()->get('em_email')));
        #Alysson - Verifica se já existe este emaill cadastrado para um usuário
        if ($emailService->filtrarObjeto()->count()) {
            $this->addErrorMessage('Email já cadastrado. Faça seu login.');

            return FALSE;
        }
        $this->getRequest()->getPost()->set('id_situacao', $this->getConfigList()['situacao_ativo']);
        $resultEmail = parent::gravar(
            $this->getServiceLocator()->get('\Email\Service\EmailService'), new \Email\Form\EmailForm()
        );


        if ($resultEmail) {

            # REalizando Tratamento do  Telefone Celular
            $this->getRequest()->getPost()->set('nr_ddd_telefone', \Estrutura\Helpers\Telefone::getDDD($this->getRequest()->getPost()->get('id_telefone_residencial')));
            $this->getRequest()->getPost()->set('nr_telefone', \Estrutura\Helpers\Telefone::getTelefone($this->getRequest()->getPost()->get('id_telefone_residencial')));
            $this->getRequest()->getPost()->set('id_tipo_telefone', $this->getConfigList()['tipo_telefone_celular']);
            $this->getRequest()->getPost()->set('id_situacao', $this->getConfigList()['situacao_ativo']);
            $resultTelefoneResidencial = parent::gravar(
                $this->getServiceLocator()->get('\Telefone\Service\TelefoneService'), new \Telefone\Form\TelefoneForm()
            );
            if ($resultTelefoneResidencial) {

                # REalizando Tratamento do  Telefone Celular
                $this->getRequest()->getPost()->set('nr_ddd_telefone', \Estrutura\Helpers\Telefone::getDDD($this->getRequest()->getPost()->get('id_telefone_celular')));
                $this->getRequest()->getPost()->set('nr_telefone', \Estrutura\Helpers\Telefone::getTelefone($this->getRequest()->getPost()->get('id_telefone_celular')));
                $this->getRequest()->getPost()->set('id_tipo_telefone', $this->getConfigList()['tipo_telefone_celular']);
                $this->getRequest()->getPost()->set('id_situacao', $this->getConfigList()['situacao_ativo']);
                $resultTelefoneCelular = parent::gravar(
                    $this->getServiceLocator()->get('\Telefone\Service\TelefoneService'), new \Telefone\Form\TelefoneForm()
                );

                if ($resultTelefoneCelular) {

                    // INSERINDO CAMPOS COM FKS DA TABELA RESPONSAVEL
                    $this->getRequest()->getPost()->set('id_email', $resultEmail);
                    $this->getRequest()->getPost()->set('id_telefone_residencial', $resultTelefoneResidencial);
                    $this->getRequest()->getPost()->set('id_telefone_celular', $resultTelefoneCelular);

                    parent::gravar(
                        $this->getServiceLocator()->get('\Responsavel\Service\ResponsavelService'), new \Responsavel\Form\ResponsavelForm()
                    );

                    $this->addSuccessMessage('Registro Inserido/Alterado com sucesso');
                    $this->redirect()->toRoute('navegacao', array('controller' => 'responsavel-responsavel', 'action' => 'index'));
                }

            }

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

    public function indexPaginationAction()
    {// funcao paginacao
        //http://igorrocha.com.br/tutorial-zf2-parte-9-paginacao-busca-e-listagem/4/

        $filter = $this->getFilterPage();

        $camposFilter = [
            '0' => NULL,

            '1' => [
                'filter' => "responsavel.nm_responsavel LIKE ?",
            ],
            '2' => NULL,
            '3' => [
                'filter' => "email.em_email LIKE ?",
            ],
            '4' => [
                'filter' => "profissao.nm_profissao LIKE ?",
            ],
            '6' => NULL,

        ];

        $paginator = $this->service->getResponsavelPaginator($filter, $camposFilter);

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

    public function autocompleteresponsavelAction()
    {
        $term = $_GET['term'];
        $arr = $this->service->getFiltrarResponsavelPorNomeToArray($term);
        $arrFiltrado = [];

        foreach ($arr as $cate) {
            $arrFiltrado[] = $cate['nm_responsavel'];
        }
        $value = new JsonModel($arrFiltrado);
        return $value;

    }

}



    