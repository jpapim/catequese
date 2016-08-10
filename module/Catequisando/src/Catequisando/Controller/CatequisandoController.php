<?php
/**
 * Created by PhpStorm.
 * User: IGOR
 * Date: 14/07/2016
 * Time: 16:46
 */

namespace Catequisando\Controller;


use Cidade\Service\CidadeService;
use Estrutura\Controller\AbstractCrudController;
use Estrutura\Helpers\Data;
use Zend\View\Model\ViewModel;


class CatequisandoController extends  AbstractCrudController{

    /**@var \Catequisando\Service\Catequisando     */
     protected $service;

    /**@var \Catequisando\Form\Catequisando     */
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
            '0' => [
                'filter' => "catequisando.nm_catequisando LIKE ?",
            ],
            '1' => null,

            '2' => NULL,

            '3' => [
                'filter' => "email.em_email LIKE ?",
            ],
            '4' => [
                'filter' => "turma.nm_turma LIKE ?",
            ],

            '5' => NULL,
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
           $controller =  $this->params('controller');

           /* @var $emailService \Email\Service\EmailService */
           $emailService = $this->getServiceLocator()->get('\Email\Service\EmailService');
           $emailService->setEmEmail(trim($this->getRequest()->getPost()->get('em_email')));

           if ($emailService->filtrarObjeto()->count()) {

               $this->addErrorMessage('Email já cadastrado. Faça seu login.');
               $this->redirect()->toRoute('navegacao', array('controller' => $controller, 'action' => 'index'));
               return FALSE;
           }

            $dataNascimento = Data::converterDataHoraBrazil2BancoMySQL($this->getRequest()->getPost()->get('dt_nascimento'));

           # Realizando Tratamento do Telefone Residencial
           $this->getRequest()->getPost()->set('nr_ddd_telefone', \Estrutura\Helpers\Telefone::getDDD($this->getRequest()->getPost()->get('id_telefone_residencial')));
           $this->getRequest()->getPost()->set('nr_telefone', \Estrutura\Helpers\Telefone::getTelefone($this->getRequest()->getPost()->get('id_telefone_residencial')));
           $this->getRequest()->getPost()->set('id_tipo_telefone', $this->getConfigList()['tipo_telefone_residencial']);
           $this->getRequest()->getPost()->set('id_situacao', $this->getConfigList()['situacao_ativo']);

           $resultTelefoneResidencial = parent::gravar(
               $this->getServiceLocator()->get('\Telefone\Service\TelefoneService'), new \Telefone\Form\TelefoneForm()
           );

            if(!empty($resultTelefoneResidencial) && $resultTelefoneResidencial){
                # REalizando Tratamento do  Telefone Celular
                $this->getRequest()->getPost()->set('nr_ddd_telefone', \Estrutura\Helpers\Telefone::getDDD($this->getRequest()->getPost()->get('id_telefone_celular')));
                $this->getRequest()->getPost()->set('nr_telefone', \Estrutura\Helpers\Telefone::getTelefone($this->getRequest()->getPost()->get('id_telefone_celular')));
                $this->getRequest()->getPost()->set('id_tipo_telefone', $this->getConfigList()['tipo_telefone_celular']);
                $this->getRequest()->getPost()->set('id_situacao', $this->getConfigList()['situacao_ativo']);

                $resultTelefoneCelular = parent::gravar(
                    $this->getServiceLocator()->get('\Telefone\Service\TelefoneService'), new \Telefone\Form\TelefoneForm()
                );

                if(!empty($resultTelefoneCelular) && $resultTelefoneCelular){

                    # Grava os dados do Endereco e retorna o ID do Endereco
                    $cidade =  new CidadeService();
                    $id_cidade = $cidade->getIdCidadePorNomeToArray($this->getRequest()->getPost()->get('id_cidade'));
                    $this->getRequest()->getPost()->set('id_cidade', $id_cidade['id_cidade']);

                    $idEndereco = parent::gravar(
                        $this->getServiceLocator()->get('\Endereco\Service\EnderecoService'),new \Endereco\Form\EnderecoForm()
                    );

                    if(!empty($idEndereco) && $idEndereco){
                        # Gravando email e retornando o ID do Email
                        $idEmail = parent::gravar(
                            $this->getServiceLocator()->get('\Email\Service\EmailService'), new \Email\Form\EmailForm()
                        );
                        if(!empty($idEmail) && $idEmail){
                            #Resgatando id de cidade e atribuindo ao campo id_naturalidade do cadastro de catequizando.
                            $id_naturalidade =  $cidade->getIdCidadePorNomeToArray($this->getRequest()->getPost()->get('id_naturalidade'));
                            $this->getRequest()->getPost()->set('id_naturalidade',$id_naturalidade['id_cidade']);

                            $this->getRequest()->getPost()->set('id_endereco',$idEndereco);
                            $this->getRequest()->getPost()->set('nm_catequisando',$this->getRequest()->getPost()->get('nm_catequisando'));
                            $this->getRequest()->getPost()->set('id_sexo', $this->getRequest()->getPost()->get('id_sexo'));
                            $this->getRequest()->getPost()->set('dt_nascimento', $dataNascimento);
                            $this->getRequest()->getPost()->set('id_telefone_residencial', $resultTelefoneResidencial);
                            $this->getRequest()->getPost()->set('id_telefone_celular', $resultTelefoneCelular);
                            $this->getRequest()->getPost()->set('id_email', $idEmail);
                            $this->getRequest()->getPost()->set('id_situacao', $this->getConfigList()['situacao_ativo']);
                            $this->getRequest()->getPost()->set('dt_ingresso', (date('d') >= 29 ? date('Y-m-' . 28 . ' H:m:s') : date('Y-m-d H:m:s')));
                            $this->getRequest()->getPost()->set('ds_situacao', 'A');

                            $resultCatequisando = parent::gravar(
                                $this->getServiceLocator()->get('\Catequisando\Service\CatequisandoService'),new \Catequisando\Form\CatequisandoForm()
                            );

                            if($resultCatequisando){
                                #Resgatando e inserindo manualmente na tabela catequisanto_etapa_cursou as ids das etapas ja realizadas.
                                $objCECService=  new \CatequisandoEtapaCursou\Service\CatequisandoEtapaCursouService();
                                $arrEtapa =  $this->getRequest()->getPost()->get('arrEtapa');

                                foreach($arrEtapa as $etapa){
                                    $objCECService->setIdEtapa($etapa);
                                    $objCECService->setIdCatequisando($resultCatequisando);
                                    $objCECService->setDtCadastro(date('Y-m-d H:m:s'));
                                    $objCECService->salvar();
                                 }

                                # Resgatando e inserindo manualmente na tabela sacramento catequisando as ids  dos sacramentos e  a id catequisando

                                #objeto do tipo SacramentoCatequisandoService
                                $objSCService= new \SacramentoCatequisando\Service\SacramentoCatequisandoService();
                                $arrSacramento =  $this->getRequest()->getPost()->get('arrSacramento');

                                foreach($arrSacramento as $sacramento){
                                    $objSCService->setIdCatequisando($resultCatequisando);
                                    $objSCService->setIdSacramento($sacramento);
                                    $objSCService->setDtCadastro(date('Y-m-d H:m:s'));
                                    $objSCService->salvar();
                                }
                                $status = true;
                            }
                        }
                    }
                }
            }

           if ($status ) {
               $this->addSuccessMessage('Parabéns! Catequizando cadastrado com sucesso.');
               $this->redirect()->toRoute('navegacao', array('controller' => $controller, 'action' => 'index'));
           }
            else{
                $this->addErrorMessage('Processo não pode ser concluido.');
                $this->redirect()->toRoute('navegacao', array('controller' => $controller, 'action' => 'cadastro'));

            }
       }

    public function cadastroAction()
    { // funn��o alterar
        #xd($this->getRequest()->getPost());
        return parent::cadastro($this->service, $this->form);
    }

    public function excluirAction()
    {
      # xd($this->getRequest()->getPost());
           return parent::excluir($this->service, $this->form);


    }


}