<?php
/**
 * Created by PhpStorm.
 * User: IGOR
 * Date: 14/07/2016
 * Time: 16:46
 */

namespace Catequizando\Controller;


use Cidade\Service\CidadeService;
use Estrutura\Controller\AbstractCrudController;
use Estrutura\Helpers\Cep;
use Estrutura\Helpers\Cript;
use Estrutura\Helpers\Data;
use Zend\View\Helper\Json;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;


class CatequizandoController extends  AbstractCrudController{

    /**@var \Catequizando\Service\CatequizandoService     */
     protected $service;

    /**@var \Catequizando\Form\CatequizandoForm     */
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
            '0' => NULL,
            '1' => [
                'filter' => "catequizando.nm_catequizando LIKE ?",
            ],
            '2' =>  [
                'filter' => "responsavel.nm_responsavel LIKE ?",
            ],

            '3' => NULL,

            '4' => [
                'filter' => "email.em_email LIKE ?",
            ],
            '5' => [
                'filter' => "turma.nm_turma LIKE ?",
            ],
            '6' => NULL,
        ];

        $paginator = $this->service->getCatequizandoPaginator($filter, $camposFilter);

        $paginator->setItemCountPerPage($paginator->getTotalItemCount());

        $countPerPage = $this->getCountPerPage(
            current(\Estrutura\Helpers\Pagination::getCountPerPage($paginator->getTotalItemCount()))
        );

        $paginator->setItemCountPerPage($this->getCountPerPage(
            current(\Estrutura\Helpers\Pagination::getCountPerPage($paginator->getTotalItemCount()))
        ))->setCurrentPageNumber($this->getCurrentPage());

        ### Setando responsavel e  turma no index



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

        return $viewModel->setTerminal(TRUE);
    }

    public function gravarAction()
    {
        $controller =  $this->params('controller');
        $status =false;
        #$pos = $this->getRequest()->getPost()->toArray();
        #$arrc = $this->service->buscar(Cript::dec($pos['id']))->toArray();


            if(Cript::dec($this->getRequest()->getPost()->get('id'))){
                $this->atualizarAction();
                return FALSE;
            }

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
            if($resultTelefoneResidencial){
                # REalizando Tratamento do  Telefone Celular
                $this->getRequest()->getPost()->set('nr_ddd_telefone', \Estrutura\Helpers\Telefone::getDDD($this->getRequest()->getPost()->get('id_telefone_celular')));
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
                        # Gravando email e retornando o ID do Email
                        $idEmail = parent::gravar(
                            $this->getServiceLocator()->get('\Email\Service\EmailService'), new \Email\Form\EmailForm()
                        );
                        if(!empty($idEmail) && $idEmail){
                            #Resgatando id de cidade e atribuindo ao campo id_naturalidade do cadastro de catequizando.
                            $id_naturalidade =  $cidade->getIdCidadePorNomeToArray($this->getRequest()->getPost()->get('nm_naturalidade'));
                            $this->getRequest()->getPost()->set('id_naturalidade',$id_naturalidade['id_cidade']);

                            $this->getRequest()->getPost()->set('id_endereco',$idEndereco);
                            $this->getRequest()->getPost()->set('nm_catequizando',$this->getRequest()->getPost()->get('nm_catequizando'));
                            $this->getRequest()->getPost()->set('id_sexo', $this->getRequest()->getPost()->get('id_sexo'));
                            $this->getRequest()->getPost()->set('dt_nascimento', $dataNascimento);
                            $this->getRequest()->getPost()->set('id_telefone_residencial', $resultTelefoneResidencial);
                            $this->getRequest()->getPost()->set('id_telefone_celular', $resultTelefoneCelular);
                            $this->getRequest()->getPost()->set('id_email', $idEmail);
                            $this->getRequest()->getPost()->set('id_situacao', $this->getConfigList()['situacao_ativo']);
                            $this->getRequest()->getPost()->set('dt_ingresso', Data::getDataAtual2Banco());
                            $this->getRequest()->getPost()->set('ds_situacao', 'A');

                            #($this->getRequest()->getPost());
                            $resultCatequizando = parent::gravar(
                                $this->getServiceLocator()->get('\Catequizando\Service\CatequizandoService'),new \Catequizando\Form\CatequizandoForm()
                            );

                            if($resultCatequizando){
                                #Resgatando e inserindo manualmente na tabela catequizando_etapa_cursou as ids das etapas ja realizadas.
                                $arrEtapa =  $this->getRequest()->getPost()->get('arrEtapa');

                               if(!empty($arrEtapa)){
                                   foreach($arrEtapa as $etapa){
                                       $this->getRequest()->getPost()->set('id_etapa', $etapa);
                                       $this->getRequest()->getPost()->set('id_catequizando', $resultCatequizando);
                                       $this->getRequest()->getPost()->set('dt_cadastro', date('Y-m-d H:m:s'));
                                       #Chamo o metodo para gravar os dados na tabela.
                                       parent::gravar(
                                           $this->getServiceLocator()->get('\CatequizandoEtapaCursou\Service\CatequizandoEtapaCursouService'), new \CatequizandoEtapaCursou\Form\CatequizandoEtapaCursouForm()
                                       );
                                   }
                               }

                                # Resgatando e inserindo manualmente na tabela sacramento catequizando as ids  dos sacramentos e  a id catequizando
                                #$objSacramentoCatequizandoService = new \SacramentoCatequizando\Service\SacramentoCatequizandoService();
                                $arrSacramento =  $this->getRequest()->getPost()->get('arrSacramento');

                                if(!empty($arrSacramento)){
                                    foreach($arrSacramento as $sacramento){
                                        $this->getRequest()->getPost()->set('id_sacramento', $sacramento);
                                        $this->getRequest()->getPost()->set('id_catequizando', $resultCatequizando);
                                        $this->getRequest()->getPost()->set('dt_cadastro', date('Y-m-d H:m:s'));

                                        parent::gravar(
                                            $this->getServiceLocator()->get('\SacramentoCatequizando\Service\SacramentoCatequizandoService'),new \SacramentoCatequizando\Form\SacramentoCatequizandoForm()
                                        );
                                    }
                                }
                                $status = true;
                            }
                        }
                    }
                }
            }


           if ($status) {

               $objCatequizando = new \Catequizando\Service\CatequizandoService();
               $arr = $objCatequizando->buscar($resultCatequizando);

               if((int)(\Estrutura\Helpers\Data::calcularIdadeDoAtleta($arr->getDtNascimento())) < 18){
                   $this->redirect()->toRoute('navegacao', array('controller' => $controller, 'action' => 'responsavelCatequizando','id' => \Estrutura\Helpers\Cript::enc($resultCatequizando)));
               }else{
                   $this->redirect()->toRoute('navegacao', array('controller' => $controller, 'action' => 'index'));
               }
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
          $arrCatequizando = $this->service->buscar($id)->toArray();

         ###################### BUSCANDO INFORMAÇÕES DO CATEQUIZANDO ######################
         ## Recuperando Email
          $objEmail = new \Email\Service\EmailService();
          $email =  $objEmail->buscar($arrCatequizando['id_email'])->toArray();

          ## Recuperando Endereco
          $objEnd = new \Endereco\Service\EnderecoService();
          $endereco= $objEnd->buscar($arrCatequizando['id_endereco'])->toArray();

          ## Recuperando Cidade
          $objCidade = new \Cidade\Service\CidadeService();
          $cidade = $objCidade->buscar($endereco['id_cidade'])->toArray();

          ## Recuperar Estado da Cidade
          $objEstado = new \Estado\Service\EstadoService();
          $estadoCidade = $objEstado->buscar($cidade['id_estado'])->toArray();

          ## Recuperando Naturalidade
          $naturalidade = $objCidade->buscar($arrCatequizando['id_naturalidade'])->toArray();

          ## Recuperar Estado da Naturalidade
          $objEstado = new \Estado\Service\EstadoService();
          $estadoNat = $objEstado->buscar($naturalidade['id_estado'])->toArray();

          ## Telefone Residencial
          $objTelefone = new \Telefone\Service\TelefoneService();
          $telResidencial = $objTelefone->buscar($arrCatequizando['id_telefone_residencial'])->toArray();

          ## Telefone Celular
          $telCelular = $objTelefone->buscar($arrCatequizando['id_telefone_celular'])->toArray();

          ## Recuperando Etapas que o Catequizando já realizou

          $obCatequizandoEtapaCursou = new \CatequizandoEtapaCursou\Service\CatequizandoEtapaCursouService();
          $etapas = $obCatequizandoEtapaCursou->select('id_catequizando = '.$id)->toArray();

          $etapa=[];
          foreach($etapas as $e){
            $etapa[]=$e['id_etapa'];
          }
        

          ## Recuperando Sacramentos que o Catequizando já Realizou
          $objSacramentoCatequizando = new \SacramentoCatequizando\Service\SacramentoCatequizandoService();
          $sacramentos = $objSacramentoCatequizando->select('id_catequizando = '.$id)->toArray();

          $sacramento=[];
          foreach($sacramentos as $s){
              $sacramento[] = $s['id_sacramento'];
          }

          ############### POPULANDO O FORMULÁRIO DO CATEQUIZANDO COM AS INFORMAÇÕES RESGATADAS ###########
          $this->getRequest()->getPost()->set('id',$arrCatequizando['id']);
          $this->getRequest()->getPost()->set('nm_catequizando',$arrCatequizando['nm_catequizando']);
          $this->getRequest()->getPost()->set('ds_situacao',$arrCatequizando['ds_situacao']);
          $this->getRequest()->getPost()->set('cs_necessidade_especial',$arrCatequizando['cs_necessidade_especial']);
          $this->getRequest()->getPost()->set('cs_estudante',$arrCatequizando['cs_estudante']);
          $this->getRequest()->getPost()->set('cs_participa_movimento_pastoral',$arrCatequizando['cs_participa_movimento_pastoral']);
          $this->getRequest()->getPost()->set('dt_nascimento',$arrCatequizando['dt_nascimento']);
          $this->getRequest()->getPost()->set('em_email',$email['em_email']);
          $this->getRequest()->getPost()->set('id_sexo',$arrCatequizando['id_sexo']);
          $this->getRequest()->getPost()->set('tx_observacao',$arrCatequizando['tx_observacao']);
          $this->getRequest()->getPost()->set('nm_logradouro', $endereco['nm_logradouro']);
          $this->getRequest()->getPost()->set('nm_bairro', $endereco['nm_bairro']);
          $this->getRequest()->getPost()->set('nm_complemento', $endereco['nm_complemento']);
          $this->getRequest()->getPost()->set('nr_numero', $endereco['nr_numero']);
          $this->getRequest()->getPost()->set('nr_cep', \Estrutura\Helpers\Cep::cepMask($endereco['nr_cep']));
          $this->getRequest()->getPost()->set('nm_cidade', $cidade['nm_cidade']." (".$estadoCidade['sg_estado'].")");
          $this->getRequest()->getPost()->set('nm_naturalidade', $naturalidade['nm_cidade']." (".$estadoNat['sg_estado'].")");
          $this->getRequest()->getPost()->set('telefone_residencial',\Estrutura\Helpers\Telefone::telefoneMask($telResidencial['nr_ddd_telefone'].$telResidencial['nr_telefone']));
          $this->getRequest()->getPost()->set('telefone_celular',($telCelular['nr_ddd_telefone'].$telCelular['nr_telefone']));

          if(!empty($arrCatequizando['nm_necessidade_especial'])){
              $this->getRequest()->getPost()->set('nm_necessidade_especial',$arrCatequizando['nm_necessidade_especial']);
          }

          $options=array();
          $options['arrSacramento']=$sacramento;
          $options['arrEtapa']= $etapa;

          #xd($this->getRequest()->getPost());
          $form=new \Catequizando\Form\CatequizandoForm($options);
          $form->setData($this->getRequest()->getPost());

          $dadosView = [
              'service' => $this->service,
              'form' => $form,
              'controller' => $this->params('controller'),
              'atributos' =>'',
              'id'=>$id
          ];

          return new ViewModel($dadosView);
      }

        return parent::cadastro($this->service, $this->form) ;

    }


    public function excluirAction($option = null)
    {
        #xd($option);
        #ID_CATEQUIZANDO
        $id = Cript::dec($this->params('id'));

        if(!empty($option)){
            $id = Cript::dec($option);
        }

        if(isset($id) && $id){
            $objcatequinzado =  new \Catequizando\Service\CatequizandoService();
            $arrCatequizando =$objcatequinzado->getCatequizandoToArray($id);


            #Excluindo dados da tabela filha - catequizando_etapa_cursou
            $obCatequizandoEtapaCursouService = new \CatequizandoEtapaCursou\Service\CatequizandoEtapaCursouService();
            $obCatequizandoEtapaCursouService->setIdCatequizando($id);
            $obCatequizandoEtapaCursouService->excluir();

            #Excluindo dados da tabela filha - responsavel_catequizando
            $objResponsavelCatequizando =new \ResponsavelCatequizando\Service\ResponsavelCatequizandoService();
            $objResponsavelCatequizando->setIdCatequizando($id);
            $objResponsavelCatequizando->excluir($id);

            #Excluindo dados da tabela filha - sacramento_catequizando
            $objSacramentoCatequizando =  new \SacramentoCatequizando\Service\SacramentoCatequizandoService();
            $objSacramentoCatequizando->setIdCatequizando($id);
            $objSacramentoCatequizando->excluir();

            #Excluindo dados da tabela filha - Turma_catequizando
            $objTurmaCatequizando =  new \TurmaCatequizando\Service\TurmaCatequizandoService();
            $objTurmaCatequizando->setIdCatequizando($id);
            $objTurmaCatequizando->excluir();

            #excluindo dados da tabela filha - pais_catequizando
            $retornoExcluir = parent::excluir($this->service, $this->form);

            #Excluindo dados da tabela -  email
            $objEmail = new \Email\Service\EmailService();
            $objEmail->setId($arrCatequizando['id_email']);
            $objEmail->excluir();

            #Excluindo dados da tabela - Telefone
            $obTelResidencial =  new \Telefone\Service\TelefoneService();
            $obTelResidencial->setId($arrCatequizando['id_telefone_residencial']);
            $obTelResidencial->excluir();

            #Excluindo dados da tabela - Telefone
            $obTelCelular =  new \Telefone\Service\TelefoneService();
            $obTelCelular->setId($arrCatequizando['id_telefone_celular']);
            $obTelCelular->excluir();

            #Excluindo dados da tabela - Endereco
            $obEndereco= new \Endereco\Service\EnderecoService();
            $obEndereco->setId($arrCatequizando['id_endereco']);
            $obEndereco->excluir();
        }

           #return $retornoExcluir;
    }

    public function atualizarAction(){


       try{


           $controller =  $this->params('controller');
           $post= $this->getRequest()->getPost()->toArray();
           $id = Cript::dec($post['id']);
           $post['id']= $id;
           $arr = $this->service->buscar($id)->toArray();

           #x($post);

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
           $id_naturalidade = $cidade->getIdCidadePorNomeToArray($this->getRequest()->getPost()->get('nm_naturalidade'));
           $this->getRequest()->getPost()->set('id_naturalidade',$id_naturalidade['id_cidade']);

           ## Atualizando Sacramento Catequizando
           $arrSacramento = $this->getRequest()->getPost()->get('arrSacramento');

          if(isset($arrSacramento) && empty($arrSacramento) != false){

              ## Excluido dados Antigos
              $objSacramento = new \SacramentoCatequizando\Service\SacramentoCatequizandoService();
              $objSacramento->setIdCatequizando($id);
              $objSacramento->excluir();

              ### Regravando  Sacramentos já realizados pelo catequizando
              foreach($arrSacramento as $sacramento){
                  $objS = new \SacramentoCatequizando\Service\SacramentoCatequizandoService();
                  $objS->setIdCatequizando($id);
                  $objS->setIdSacramento($sacramento);
                  $objS->salvar();
              }
          }

           ## Atualizando Catequizando Etapa Cursou
           $arrEtapa = $this->getRequest()->getPost()->get('arrEtapa');

            if(isset($arrEtapa) && empty($arrEtapa) != false){

                ## Excluindo dados Antigos
                $obEtapa = new \CatequizandoEtapaCursou\Service\CatequizandoEtapaCursouService();
                $obEtapa->setIdCatequizando($id);
                $obEtapa->excluir();

                ## Regravando Catequizando Etapa Cursou  já realizado pelo Catequizando
                foreach($arrEtapa as $etapa){
                    $et =  new \CatequizandoEtapaCursou\Service\CatequizandoEtapaCursouService();
                    $et->setIdEtapa($etapa);
                    $et->setIdCatequizando($id);
                    $et->salvar();
                }
            }

            $this->getRequest()->getPost()->set('dt_nascimento',Data::converterDataHoraBrazil2BancoMySQL($post['dt_nascimento']));

           #xd($arr);

           $form = new \Catequizando\Form\CatequizandoForm();
          $bool = parent::gravar(
               $this->getServiceLocator()->get('\Catequizando\Service\CatequizandoService'),$form
           );

          if($bool == true){
              $this->addSuccessMessage('Parabéns! Catequizando cadastrado com sucesso.');
              $this->redirect()->toRoute('navegacao', array('controller' => $controller, 'action' => 'index'));
          }

       }catch (\Exception $e) {

           $this->setPost($post);
           $this->addErrorMessage($e->getMessage());
           $this->redirect()->toRoute('navegacao', array('controller' => $controller, 'action' => 'cadastro'));
           return FALSE;
       }

    }


    public function responsavelCatequizandoAction(){

       $id_catequizando  = \Estrutura\Helpers\Cript::dec($this->params('id'));

        $catequizando = $this->service->buscar($id_catequizando);

        $dadosView = [
            'controller' => $this->params('controller'),
            'id_catequizando'=>$id_catequizando,
            'catequizando'=>$catequizando,
            'atributos' =>''
        ];

        return new ViewModel($dadosView);

    }

    #### Actions para o caso de o Responsável não  tiver sido cadastrado no Sistema
    public function responsavelFormCadAction(){

        $form = new \Catequizando\Form\CatequizandoResponsavelForm();
        $catequizando = $this->service->buscar($this->params()->fromPost('id_catequizando'));

        $dadosView = [
            'service' => $this->service,
            'form' => $form,
            'catequizando'=>$catequizando,
            'controller' => $this->params('controller'),
            'atributos' =>''
        ];
        $view = new ViewModel($dadosView);

        return $view->setTerminal(true);

    }

    ### Função para excluir chaves e valores de um array
   private function unsetPersonalizadoAction($vetor ,$excluir ){

        if(!is_array($vetor) ||!is_array($excluir)) {
            throw new \Exception('Os dados devem ser um array');
        }
        foreach($excluir as $value):

            if(array_key_exists($value,$vetor)){
                unset($vetor[$value]);
            }
        endforeach;

        return $vetor;
    }

    public function addResponsavelViaCadastroAction(){

        if($this->getRequest()->isPost()){

            try{
                $post = $this->params()->fromPost();
                $controller = $this->params('controller');

                #xd($post);
                ## Id do catequizando para gravar no responsavel-catequizando
                $id_catequizando = \Estrutura\Helpers\Cript::dec($post['id_catequizando']);

                $emailService = $this->getServiceLocator()->get('\Email\Service\EmailService');
                $emailService->setEmEmail(trim($post['em_email']));

                ### Verificando se email já não é cadastrado
                if ($emailService->filtrarObjeto()->count()) {
                    $this->addErrorMessage('Email já cadastrado.');
                    $this->redirect()->toRoute('navegacao', array('controller' => $controller, 'action' => 'responsavelCatequizando'));
                    return FALSE;
                }
                ### Gravando email e recuperando o id_email
                 $post['id_email'] = parent::gravar(
                     $this->getServiceLocator()->get('\Email\Service\EmailService'), new \Email\Form\EmailForm()
                 );

                # REalizando Tratamento do  Telefone Residencial
                $this->getRequest()->getPost()->set('nr_ddd_telefone', \Estrutura\Helpers\Telefone::getDDD($post['id_telefone_residencial']));
                $this->getRequest()->getPost()->set('nr_telefone', \Estrutura\Helpers\Telefone::getTelefone($post['id_telefone_residencial']));
                $this->getRequest()->getPost()->set('id_tipo_telefone',$this->getConfigList()['tipo_telefone_residencial']);
                $this->getRequest()->getPost()->set('id_situacao', $this->getConfigList()['situacao_ativo']);

                $post['id_telefone_residencial'] = parent::gravar(
                    $this->getServiceLocator()->get('\Telefone\Service\TelefoneService'), new \Telefone\Form\TelefoneForm()
                );

                # REalizando Tratamento do  Telefone Celular
                $this->getRequest()->getPost()->set('nr_ddd_telefone', \Estrutura\Helpers\Telefone::getDDD($post['id_telefone_celular']));
                $this->getRequest()->getPost()->set('nr_telefone', \Estrutura\Helpers\Telefone::getTelefone($post['id_telefone_celular']));
                $this->getRequest()->getPost()->set('id_tipo_telefone',$this->getConfigList()['tipo_telefone_celular']);
                $this->getRequest()->getPost()->set('id_situacao', $this->getConfigList()['situacao_ativo']);

                #### passando informações para situacao_conjugal e grau_parentesco para outras variaveis

                $dados['id_grau_parentesco'] =$post['id_grau_parentesco'];
                $dados['id_situacao_conjugal'] = $post['id_situacao_conjugal'];

                $post['id_telefone_celular'] = parent::gravar(
                    $this->getServiceLocator()->get('\Telefone\Service\TelefoneService'), new \Telefone\Form\TelefoneForm()
                );

                #### Retirando campos do array
                $post = $this->unsetPersonalizadoAction($post, [
                    'id_catequizando','em_email','em_email_confirm','id_situacao_conjugal','id_situacao','id_grau_parentesco']);


                #### Gravando Dados do responsavel
                $responsavel = new \Responsavel\Service\ResponsavelService();
                $id_responsavel = $responsavel->getTable()->salvar($post,null);

                ##### Gravando dados  na tabela responsavel_catequizando
                $dados['id_responsavel'] = $id_responsavel;
                $dados['id_catequizando'] = $id_catequizando;


                $responsavel_catequizando = new \ResponsavelCatequizando\Service\ResponsavelCatequizandoService();
                $id_inserido = $responsavel_catequizando->getTable()->salvar($dados,null);

                $valuesJson = new JsonModel(array('id_inserido' => $id_inserido, 'sucesso' => true));
                return $valuesJson;

            }catch (\PDOException $e){
                $this->addErrorMessage('Erro ao execultar gravação de responável:'.$e->getMessage());
            }

            return null;
        }

    }
    #########################################################


    ### Paginação dos Responsáveis do catequizando
    public function catequizandoResponsavelPaginationAction()
    {
        #$this->params()->fromPost('paramname');   // From POST
        #$this->params()->fromQuery('paramname');  // From GET
        #$this->params()->fromRoute('paramname');  // From RouteMatch
        #$this->params()->fromHeader('paramname'); // From header
        #$this->params()->fromFiles('paramname');  // From file being uploaded

        $filter = $this->getFilterPage();

        $id_catequizando = $this->params()->fromPost('id_catequizando');

        #$id_catequizando = isset($id_catequizando) && $id_catequizando ? $id_catequizando : $this->params()->fromRoute('id');

        $camposFilter = [


        ];

        $paginator = $this->service->getCatequizandoResponsavelPaginator($id_catequizando, $filter, $camposFilter);

        $paginator->setItemCountPerPage($paginator->getTotalItemCount());

        $countPerPage = $this->getCountPerPage(
            current(\Estrutura\Helpers\Pagination::getCountPerPage($paginator->getTotalItemCount()))
        );

        $paginator->setItemCountPerPage($this->getCountPerPage(
            current(\Estrutura\Helpers\Pagination::getCountPerPage($paginator->getTotalItemCount()))
        ))->setCurrentPageNumber($this->getCurrentPage());

        $viewModel = new ViewModel([
            'service' => $this->service,
            'form' => new \Catequizando\Form\CatequizandoResponsavelForm(),
            'paginator' => $paginator,
            'filter' => $filter,
            'countPerPage' => $countPerPage,
            'camposFilter' => $camposFilter,
            'controller' => $this->params('controller'),
            'id_catequizando' => $id_catequizando,
            'atributos' => array()
        ]);

        return $viewModel->setTerminal(true);
    }

    #### Actions para o caso de o Responsável já tiver sido cadastrado no Sistema

    ## Action da página responsavel-form-detalhe : página chamada via ajax
    public function responsavelFormDetalheAction(){

        $form = new \Catequizando\Form\CatequizandoResponsavelForm();

        $catequizando = $this->service->buscar($this->params()->fromPost('id_catequizando'));

        $dadosView = [
            'service' => $this->service,
            'form' => $form,
            'catequizando'=> $catequizando,
            'controller' => $this->params('controller'),
            'atributos' =>''
        ];

        $view = new ViewModel($dadosView);
        return $view->setTerminal(true);
    }

    ### Add Responsavel  , Action insere na tabela responsavel_catequizando
    public function addresponsavelAction(){

        if($this->getRequest()->isPost()){

            $post = $this->params()->fromPost();
            $post['id_catequizando']=\Estrutura\Helpers\Cript::dec($post['id_catequizando']);

            ### Recuperando Id Responsavel ###
            $resp = new \Responsavel\Service\ResponsavelService();
            $resInfo = $resp->getFiltrarResponsavelPorNomeToArray($post['id_responsavel'])->current();
            $post['id_responsavel'] = $resInfo['id_responsavel'];

            $responsavel_catequizando = new \ResponsavelCatequizando\Service\ResponsavelCatequizandoService();
            $id_inserido = $responsavel_catequizando->getTable()->salvar($post,null);

            $valuesJson = new JsonModel(array('id_inserido' => $id_inserido, 'sucesso' => true));


            return $valuesJson;
        }

    }

    ### Autocomplete para o nome do Responsavél caso ele esteja no sistema.
    public function autoCompleteResponsavelAction()
    {
        $term = $_GET['term'];
        $responsaveis = new \Responsavel\Service\ResponsavelService();
        $arrResponsaveis = $responsaveis->getFiltrarResponsavelPorNomeToArray($term);
        $arrRespFiltro = array();
        foreach($arrResponsaveis as $resp){

            $arrRespFiltro[] = $resp['nm_responsavel'];
        }

        $valuesJson = new JsonModel( $arrRespFiltro);
        return $valuesJson;
    }

    ### exclusão do responsável
    public function excluirResponsavelCatequizandoAction()
    {
        $request = $this->getRequest();

        if ($request->isPost()) {
            return new JsonModel();
        }
        $id = \Estrutura\Helpers\Cript::dec($this->params('id'));
        $objResCat = new \ResponsavelCatequizando\Service\ResponsavelCatequizandoService();

        $objResCat->setId($id);
        $objResCat->excluir();

        $this->addSuccessMessage('Registro excluido com sucesso');

        return $this->redirect()->toRoute('navegacao',array('controller'=>$this->params('controller'),'action'=>'responsavelCatequizando'));
    }

    public function autocompleteAction(){
        $term =  $_GET['term'];
        $arr = $this->service->getFiltrarCatequizandoPorNomeToArray($term);
        $arrFiltrado =[];

        foreach($arr as $cate){
           $arrFiltrado[]=$cate['nm_catequizando'];
        }
        $value = new JsonModel($arrFiltrado);
        return $value;

    }

}