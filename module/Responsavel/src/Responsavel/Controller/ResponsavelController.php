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
                $this->getRequest()->getPost()->set('nr_telefone', \Estrutura\Helpers\Telefone::getCelular($this->getRequest()->getPost()->get('id_telefone_celular')));
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

                    $resultResponsavel = parent::gravar(
                        $this->getServiceLocator()->get('\Responsavel\Service\ResponsavelService'), new \Responsavel\Form\ResponsavelForm()
                    );

                    #Se cadastro realizado com sucesso, dispara um email para o usuario
                    if ($resultResponsavel) {


                        $contaEmail = 'no-reply';

                        $message = new \Zend\Mail\Message();
                        $message->addFrom($contaEmail . '@acthosti.com.br', 'Nao responda.')
                            ->addTo(trim($this->getRequest()->getPost()->get('em_email')))#Envia para o Email que cadastrou
                            ->addBcc('alysson.vicuna@gmail.com')
                            ->setSubject('Confirmação de cadastro no sistema Catequese');

                        $applicationService = new \Application\Service\ApplicationService();
                        $transport = $applicationService->getSmtpTranport($contaEmail);

                        $htmlMessage = $applicationService->tratarModelo(
                            [
                                'BASE_URL' => BASE_URL,
                                'nomeResponsavel' => trim($this->getRequest()->getPost()->get('nm_usuario')),
                                #'txIdentificacao' => base64_encode(\Estrutura\Helpers\Bcrypt::hash('12345678')),
                                'email' => trim($this->getRequest()->getPost()->get('em_email')),
                            ], $applicationService->getModelo('cadastro-responsavel'));

                        $html = new \Zend\Mime\Part($htmlMessage);
                        $html->type = "text/html";

                        $body = new \Zend\Mime\Message();
                        $body->addPart($html);

                        $message->setBody($body);
                        $transport->send($message);

                        $this->addSuccessMessage('Registro salvo com sucesso!');
                        $this->redirect()->toRoute('navegacao', array('controller' => 'responsavel-responsavel', 'action' => 'index'));

                    } else {
                        $this->addErrorMessage('Erro ao cadastrar responsável!');
                        $this->redirect()->toRoute('navegacao', array('controller' => 'responsavel-responsavel', 'action' => 'index'));
                    }
                    #Fim do cadastro de responsavel

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
            '2' => [
                'filter' => "telefone.nr_telefone LIKE ?",
            ],
            '3' => [
                'filter' => "telefone.nr_telefone LIKE ?",
            ],
            '4' => [
                'filter' => "email.em_email LIKE ?",
            ],
            '6' => [
                'filter' => "profissao.nm_profissao LIKE ?",
            ],
            '7' => NULL,
            '8' => NULL,

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

    public function recuperarCatequizandoAction()
    {
        #$post = $this->params()->fromPost();
        $id_responsavel = $this->params()->fromPost('id_responsavel');

        $responsavelcatequizandoService = new \ResponsavelCatequizando\Service\ResponsavelCatequizandoService();
        $responsavelcatequizandoService->setIdResponsavel($id_responsavel);
        $obResponsavelCatequizandoEntity = $responsavelcatequizandoService->filtrarObjeto();

        if (count($obResponsavelCatequizandoEntity) > 0) {
            $catequizandoService = new \Catequizando\Service\CatequizandoService();
            foreach ($obResponsavelCatequizandoEntity as $obResponsavelCatequizando) {
                $catequizandoEntity = $catequizandoService->buscar($obResponsavelCatequizando->getIdCatequizando());
                $arNome[] = $catequizandoEntity->getNmCatequizando();
            }
        } else {
            $arNome[] = "<p><h3>Não é responsável por nenhum catequizando.</h3></p>";
        }
        #Até aqui esta certo.


        $valuesJson = new JsonModel(array('arNomes' => $arNome));
        return $valuesJson;
    }

}



    