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
use Estrutura\Helpers\Cep;
use Estrutura\Helpers\Cript;
use Estrutura\Helpers\Data;
use Zend\View\Model\ViewModel;


class CatequisandoController extends  AbstractCrudController{

    /**@var \Catequisando\Service\CatequisandoService     */
     protected $service;

    /**@var \Catequisando\Form\CatequisandoForm     */
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
            '1' => [
                'filter' => "responsavel.nm_responsavel LIKE ?",
            ],

            '2' =>[
                'filter' => "telefone.nr_telefone LIKE ?",
            ],

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
        $id_catequizando = Cript::dec($this->getRequest()->getPost()->get('id'));

        $pos = $this->getRequest()->getPost()->toArray();
        #$arrc = $this->service->buscar(Cript::dec($pos['id']))->toArray();

            if(isset($id_catequizando) && $id_catequizando){
                $this->atualizarAction();
                return FALSE;
            }

        /* @var $emailService \Email\Service\EmailService */
            $emailService = $this->getServiceLocator()->get('\Email\Service\EmailService');
            $emailService->setEmEmail(trim($this->getRequest()->getPost()->get('em_email')));
            if ($emailService->filtrarObjeto()->count()) {

                if(!isset($id_catequizando) ){
                    $this->addErrorMessage('Email já cadastrado. Faça seu login.');
                    $this->redirect()->toRoute('navegacao', array('controller' => $controller, 'action' => 'index'));
                    return FALSE;
                } else {
                    $emailService->setId($this->service->buscar($id_catequizando)->getIdEmail());
                    $emailService->setEmEmail($pos['em_email']);
                   # $this->getRequest()->getPost()->set('id_email', $this->service->buscar($id_catequizando)->getIdEmail());
                }

            }

        $dateNascimento = \DateTime::createFromFormat('d/m/Y', $this->getRequest()->getPost()->get('dt_nascimento'));
        $dataMaioridade = new \Datetime();
        $dataMaioridade->modify('-8 years');

        if ($dateNascimento > $dataMaioridade) {

            $this->addErrorMessage('O Cadastrado não apresenta idade mínima.');
            $this->redirect()->toRoute('navegacao', array('controller' => $controller, 'action' =>'cadastro',true));
            return FALSE;
        }
        $dataNascimento = Data::converterDataHoraBrazil2BancoMySQL($this->getRequest()->getPost()->get('dt_nascimento'));


           # Realizando Tratamento do Telefone Residencial
           $this->getRequest()->getPost()->set('nr_ddd_telefone', \Estrutura\Helpers\Telefone::getDDD($this->getRequest()->getPost()->get('telefone_residencial')));
           $this->getRequest()->getPost()->set('nr_telefone', \Estrutura\Helpers\Telefone::getTelefone($this->getRequest()->getPost()->get('telefone_residencial')));
            #xd( $this->getRequest()->getPost()->get('nr_telefone'));
           $this->getRequest()->getPost()->set('id_tipo_telefone', $this->getConfigList()['tipo_telefone_residencial']);
           $this->getRequest()->getPost()->set('id_situacao', $this->getConfigList()['situacao_ativo']);
           $resultTelefoneResidencial = parent::gravar(
               $this->getServiceLocator()->get('\Telefone\Service\TelefoneService'), new \Telefone\Form\TelefoneForm()
           );

            if($resultTelefoneResidencial){
                # REalizando Tratamento do  Telefone Celular
                $this->getRequest()->getPost()->set('nr_ddd_telefone', \Estrutura\Helpers\Telefone::getDDD($this->getRequest()->getPost()->get('telefone_celular')));
                $this->getRequest()->getPost()->set('nr_telefone', \Estrutura\Helpers\Telefone::getTelefone($this->getRequest()->getPost()->get('telefone_celular')));
                $this->getRequest()->getPost()->set('id_tipo_telefone', $this->getConfigList()['tipo_telefone_celular']);
                $this->getRequest()->getPost()->set('id_situacao', $this->getConfigList()['situacao_ativo']);

                $resultTelefoneCelular = parent::gravar(
                    $this->getServiceLocator()->get('\Telefone\Service\TelefoneService'), new \Telefone\Form\TelefoneForm()
                );

                if($resultTelefoneCelular){

                    # Grava os dados do Endereco e retorna o ID do Endereco
                    $cidade =  new CidadeService();
                    $id_cidade = $cidade->getIdCidadePorNomeToArray($this->getRequest()->getPost()->get('nm_cidade'));
                    $this->getRequest()->getPost()->set('id_cidade', $id_cidade['id_cidade']);
                    $this->getRequest()->getPost()->set('nr_cep', \Estrutura\Helpers\Cep::cepFilter($this->getRequest()->getPost()->get('nr_cep')));
                    $idEndereco = parent::gravar(
                        $this->getServiceLocator()->get('\Endereco\Service\EnderecoService'),new \Endereco\Form\EnderecoForm()
                    );

                    if($idEndereco){
                         #Gravando email e retornando o ID do Email
                       $idEmail = parent::gravar(
                            $this->getServiceLocator()->get('\Email\Service\EmailService'), new \Email\Form\EmailForm()
                        );

                        if(!empty($idEmail) && $idEmail){
                            #Resgatando id de cidade e atribuindo ao campo id_naturalidade do cadastro de catequizando.
                            $id_naturalidade =  $cidade->getIdCidadePorNomeToArray($this->getRequest()->getPost()->get('nm_naturalidade'));
                            $this->getRequest()->getPost()->set('id_naturalidade',$id_naturalidade['id_cidade']);

                            $this->getRequest()->getPost()->set('id_endereco',$idEndereco);
                            $this->getRequest()->getPost()->set('nm_catequisando',$this->getRequest()->getPost()->get('nm_catequisando'));
                            $this->getRequest()->getPost()->set('id_sexo', $this->getRequest()->getPost()->get('id_sexo'));
                            $this->getRequest()->getPost()->set('dt_nascimento', $dataNascimento);
                            $this->getRequest()->getPost()->set('id_telefone_residencial', $resultTelefoneResidencial);
                            $this->getRequest()->getPost()->set('id_telefone_celular', $resultTelefoneCelular);
                            $this->getRequest()->getPost()->set('id_email', $idEmail);
                            $this->getRequest()->getPost()->set('id_situacao', $this->getConfigList()['situacao_ativo']);
                            $this->getRequest()->getPost()->set('dt_ingresso', Data::getDataAtual2Banco());
                            $this->getRequest()->getPost()->set('ds_situacao', 'A');

                            $resultCatequisando = parent::gravar(
                                $this->getServiceLocator()->get('\Catequisando\Service\CatequisandoService'),new \Catequisando\Form\CatequisandoForm()
                            );

                            if($resultCatequisando){
                                #Resgatando e inserindo manualmente na tabela catequisanto_etapa_cursou as ids das etapas ja realizadas.
                                $arrEtapa =  $this->getRequest()->getPost()->get('arrEtapa');

                                foreach($arrEtapa as $etapa){
                                    $this->getRequest()->getPost()->set('id_etapa', $etapa);
                                    $this->getRequest()->getPost()->set('id_catequisando', $resultCatequisando);
                                    $this->getRequest()->getPost()->set('dt_cadastro', date('Y-m-d H:m:s'));
                                    #Chamo o metodo para gravar os dados na tabela.
                                    parent::gravar(
                                        $this->getServiceLocator()->get('\CatequisandoEtapaCursou\Service\CatequisandoEtapaCursouService'), new \CatequisandoEtapaCursou\Form\CatequisandoEtapaCursouForm()
                                    );
                                 }


                                # Resgatando e inserindo manualmente na tabela sacramento catequisando as ids  dos sacramentos e  a id catequisando
                                #$objSacramentoCatequisandoService = new \SacramentoCatequisando\Service\SacramentoCatequisandoService();
                                $arrSacramento =  $this->getRequest()->getPost()->get('arrSacramento');

                                foreach($arrSacramento as $sacramento){
                                    $this->getRequest()->getPost()->set('id_sacramento', $sacramento);
                                    $this->getRequest()->getPost()->set('id_catequisando', $resultCatequisando);
                                    $this->getRequest()->getPost()->set('dt_cadastro', date('Y-m-d H:m:s'));

                                    parent::gravar(
                                      $this->getServiceLocator()->get('\SacramentoCatequisando\Service\SacramentoCatequisandoService'),new \SacramentoCatequisando\Form\SacramentoCatequisandoForm()
                                    );
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
    {
      $id =  \Estrutura\Helpers\Cript::dec($this->params('id'));


      if(isset($id) && $id){
          $arrCatequisando = $this->service->buscar($id)->toArray();

         ###################### BUSCANDO INFORMAÇÕES DO CATEQUIZANDO ######################
         ## Recuperando Email
          $objEmail = new \Email\Service\EmailService();
          $email =  $objEmail->buscar($arrCatequisando['id_email'])->toArray();

          ## Recuperando Endereco
          $objEnd = new \Endereco\Service\EnderecoService();
          $endereco= $objEnd->buscar($arrCatequisando['id_endereco'])->toArray();

          ## Recuperando Cidade
          $objCidade = new \Cidade\Service\CidadeService();
          $cidade = $objCidade->buscar($endereco['id_cidade'])->toArray();

          ## Recuperar Estado da Cidade
          $objEstado = new \Estado\Service\EstadoService();
          $estadoCidade = $objEstado->buscar($cidade['id_estado'])->toArray();

          ## Recuperando Naturalidade
          $naturalidade = $objCidade->buscar($arrCatequisando['id_naturalidade'])->toArray();

          ## Recuperar Estado da Naturalidade
          $objEstado = new \Estado\Service\EstadoService();
          $estadoNat = $objEstado->buscar($naturalidade['id_estado'])->toArray();

          ## Telefone Residencial
          $objTelefone = new \Telefone\Service\TelefoneService();
          $telResidencial = $objTelefone->buscar($arrCatequisando['id_telefone_residencial'])->toArray();

          ## Telefone Celular
          $telCelular = $objTelefone->buscar($arrCatequisando['id_telefone_celular'])->toArray();

          ## Recuperando Etapas que o Catequisando já realizou

          $obCatequisandoEtapaCursou = new \CatequisandoEtapaCursou\Service\CatequisandoEtapaCursouService();
          $etapas = $obCatequisandoEtapaCursou->select('id_catequisando = '.$id)->toArray();

          $etapa=[];
          foreach($etapas as $e){
            $etapa[]=$e['id_etapa'];
          }
        

          ## Recuperando Sacramentos que o Catequisando já Realizou
          $objSacramentoCatequisando = new \SacramentoCatequisando\Service\SacramentoCatequisandoService();
          $sacramentos = $objSacramentoCatequisando->select('id_catequisando = '.$id)->toArray();

          $sacramento=[];
          foreach($sacramentos as $s){
              $sacramento[] = $s['id_sacramento'];
          }

          ############### POPULANDO O FORMULÁRIO DO CATEQUISANDO COM AS INFORMAÇÕES RESGATADAS ###########

          $this->getRequest()->getPost()->set('em_email',$email['em_email']);

          $this->getRequest()->getPost()->set('nm_logradouro', $endereco['nm_logradouro']);
          $this->getRequest()->getPost()->set('nm_bairro', $endereco['nm_bairro']);
          $this->getRequest()->getPost()->set('nm_complemento', $endereco['nm_complemento']);
          $this->getRequest()->getPost()->set('nr_numero', $endereco['nr_numero']);
          $this->getRequest()->getPost()->set('nr_cep', \Estrutura\Helpers\Cep::cepMask($endereco['nr_cep']));
          $this->getRequest()->getPost()->set('nm_cidade', $cidade['nm_cidade']." (".$estadoCidade['sg_estado'].")");
          $this->getRequest()->getPost()->set('nm_naturalidade', $naturalidade['nm_cidade']." (".$estadoNat['sg_estado'].")");
          $this->getRequest()->getPost()->set('telefone_residencial',\Estrutura\Helpers\Telefone::telefoneFilter($telResidencial['nr_ddd_telefone'].$telResidencial['nr_telefone']));
          $this->getRequest()->getPost()->set('telefone_celular',($telCelular['nr_ddd_telefone'].$telCelular['nr_telefone']));

          $options=array();
          $options['arrSacramento']=$sacramento;
          $options['arrEtapa']= $etapa;


          $form=new \Catequisando\Form\CatequisandoForm($options);
          $form->setData($arrCatequisando);
          $form->setData($this->getRequest()->getPost());

          #x($this->getRequest()->getPost()->get('telefone_residencial'));
          $dadosView = [
              'service' => $this->service,
              'form' => $form,
              'controller' => $this->params('controller'),
              'atributos' =>''
          ];

          return new ViewModel($dadosView);

      }

        return parent::cadastro($this->service, $this->form) ;

    }


    public function excluirAction($option = null)
    {
        #xd($option);
        #ID_CATEQUISANDO
        $id = Cript::dec($this->params('id'));

        if(!empty($option)){
            $id = Cript::dec($option);
        }

        if(isset($id) && $id){
            $objcatequinsado =  new \Catequisando\Service\CatequisandoService();
            $arrCatequisando =$objcatequinsado->getCatequisandoToArray($id);



            #Excluindo dados da tabela filha - catequisando_etapa_cursou
            $obCatequisandoEtapaCursouService = new \CatequisandoEtapaCursou\Service\CatequisandoEtapaCursouService();
            $obCatequisandoEtapaCursouService->setIdCatequisando($id);
            $obCatequisandoEtapaCursouService->excluir();

            #Excluindo dados da tabela filha - responsavel_catequisando
            $objResponsavelCatequisando =new \ResponsavelCatequisando\Service\ResponsavelCatequisandoService();
            $objResponsavelCatequisando->setIdCatequisando($id);
            $objResponsavelCatequisando->excluir($id);

            #Excluindo dados da tabela filha - sacramento_catequisando
            $objSacramentoCatequisando =  new \SacramentoCatequisando\Service\SacramentoCatequisandoService();
            $objSacramentoCatequisando->setIdCatequisando($id);
            $objSacramentoCatequisando->excluir();

            #Excluindo dados da tabela filha - Turma_catequisando
            $objTurmaCatequisando =  new \TurmaCatequisando\Service\TurmaCatequisandoService();
            $objTurmaCatequisando->setIdCatequisando($id);
            $objTurmaCatequisando->excluir();

            #excluindo dados da tabela filha - pais_catequisando
            $retornoExcluir = parent::excluir($this->service, $this->form);

            #Excluindo dados da tabela -  email
            $objEmail = new \Email\Service\EmailService();
            $objEmail->setId($arrCatequisando['id_email']);
            $objEmail->excluir();

            #Excluindo dados da tabela - Telefone
            $obTelResidencial =  new \Telefone\Service\TelefoneService();
            $obTelResidencial->setId($arrCatequisando['id_telefone_residencial']);
            $obTelResidencial->excluir();

            #Excluindo dados da tabela - Telefone
            $obTelCelular =  new \Telefone\Service\TelefoneService();
            $obTelCelular->setId($arrCatequisando['id_telefone_celular']);
            $obTelCelular->excluir();

            #Excluindo dados da tabela - Endereco
            $obEndereco= new \Endereco\Service\EnderecoService();
            $obEndereco->setId($arrCatequisando['id_endereco']);
            $obEndereco->excluir();
        }

           #return $retornoExcluir;
    }

    public function atualizarAction(){

        $controller =  $this->params('controller');
       try{
           $post= $this->getRequest()->getPost()->toArray();
           $id = Cript::dec($post['id']);
           $post['id']= $id;
           $arr = $this->service->buscar($id)->toArray();

            ### Modificando o formato da data de nascimento para inserir no banco de dados.
           $post['dt_nascimento'] = Data:: converterDataHoraBrazil2BancoMySQL($post['dt_nascimento']);
           ### Atualizando Email;
           $objEmail = new \Email\Service\EmailService();
           $objEmail->setId($arr['id_email']);
           $objEmail->setEmEmail($post['em_email']);
           $objEmail->salvar();

           ### Atualizando Telefone Residencial
           $objTelefone = new \Telefone\Service\TelefoneService();
           $objTelefone->setId($arr['id_telefone_residencial']);
           $telefone =  \Estrutura\Helpers\Telefone::telefoneMask($post['telefone_residencial']);
           $objTelefone->setNrDddTelefone(\Estrutura\Helpers\Telefone::getDDD($telefone));
           $objTelefone->setNrTelefone(\Estrutura\Helpers\Telefone::getTelefone($telefone));
           #xd($objTelefone->getNrTelefone());
           $objTelefone->salvar();

           ### Atualizando Telefone Celular
           $objTelefone = new \Telefone\Service\TelefoneService();
           $objTelefone->setId($arr['id_telefone_celular']);
           $telefone =  \Estrutura\Helpers\Telefone::telefoneMask($post['telefone_celular']);
           $objTelefone->setNrDddTelefone(\Estrutura\Helpers\Telefone::getDDD($telefone));
           $objTelefone->setNrTelefone(\Estrutura\Helpers\Telefone::getTelefone($telefone));
           $objTelefone->salvar();

           ### Atualizando Endereco
           $objEndereco = new \Endereco\Service\EnderecoService();
           $objEndereco->setId($arr['id_endereco']);
           $objEndereco->setNmLogradouro($post['nm_logradouro']);
           $objEndereco->setNmComplemento($post['nm_complemento']);
           $objEndereco->setNrNumero($post['nr_numero']);
           $objEndereco->setNmBairro($post['nm_bairro']);
           $objEndereco->setNrCep(Cep::cepFilter($post['nr_cep']));

           ## Recuperando id da Cidade
           $cidade =  new CidadeService();
           $id_cidade = $cidade->getIdCidadePorNomeToArray($post['nm_cidade']);
           $objEndereco->setIdCidade($id_cidade['id_cidade']);
           $objEndereco->salvar();

           ## Recuperando id da Naturalidade
           $id_naturalidade = $cidade->getIdCidadePorNomeToArray($post['nm_naturalidade']);
           $post['id_naturalidade']= $id_naturalidade['id_cidade'];

           #x($post);

           ## Atualizando Sacramento Catequisando
           $arrSacramento = $this->getRequest()->getPost()->get('arrSacramento');

           #x($arrSacramento);
           ## Excluido dados Antigos
           $objSacramento = new \SacramentoCatequisando\Service\SacramentoCatequisandoService();
           $objSacramento->setIdCatequisando($id);
           $objSacramento->excluir();

           ### Regravando  Sacramentos já realizados pelo catequizando
           foreach($arrSacramento as $sacramento){
               $objS = new \SacramentoCatequisando\Service\SacramentoCatequisandoService();
               $objS->setIdCatequisando($id);
               $objS->setIdSacramento($sacramento);
               $objS->salvar();
           }

           ## Atualizando Catequisando Etapa Cursou
           $arrEtapa = $this->getRequest()->getPost()->get('arrEtapa');
           #x($arrEtapa);

           ## Excluindo dados Antigos
           $obEtapa = new \CatequisandoEtapaCursou\Service\CatequisandoEtapaCursouService();
           $obEtapa->setIdCatequisando($id);
           $obEtapa->excluir();

           ## Regravando Ctequisando Etapa Cursou  já realizado pelo Catequizando
          foreach($arrEtapa as $etapa){
              $et =  new \CatequisandoEtapaCursou\Service\CatequisandoEtapaCursouService();
              $et->setIdEtapa($etapa);
              $et->setIdCatequisando($id);
              $et->salvar();
          }


           #x($post['dt_nascimento']);
           #xd($post);
           $form = new \Catequisando\Form\CatequisandoForm();
           $form->setData($post);
          
           $my_service = new \Catequisando\Service\CatequisandoService();
           $my_service->exchangeArray($post);

           $this->addSuccessMessage('Parabéns! Catequizando cadastrado com sucesso.');
           $this->redirect()->toRoute('navegacao', array('controller' => $controller, 'action' => 'index'));

           return  $my_service->salvar();;

       }catch (\Exception $e) {

           $this->setPost($post);
           $this->addErrorMessage($e->getMessage());
           $this->redirect()->toRoute('navegacao', array('controller' => $controller, 'action' => 'cadastro'));
           return FALSE;
       }

    }


}