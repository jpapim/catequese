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
#$dateNascimento = \DateTime::createFromFormat('d/m/Y', $this->getRequest()->getPost()->get('dt_nascimento'));
#$dateIngresso = \DateTime::createFromFormat('d/m/Y', $this->getRequest()->getPost()->get('dt_ingresso'));
 $dataNascimento = Data::converterDataHoraBrazil2BancoMySQL($this->getRequest()->getPost()->get('dt_nascimento'));
  $dataIngresso = Data::converterDataHoraBrazil2BancoMySQL($this->getRequest()->getPost()->get('dt_ingresso'));







###########################- GRAVANDO EMAIL -#######################################################################
     
      $form = new \Catequista\Form\CatequistaForm();
        /* @var $emailService \Email\Service\EmailService */
        $emailService = $this->getServiceLocator()->get('\Email\Service\EmailService');
        $emailService->setEmEmail(trim($this->getRequest()->getPost()->get('em_email')));
        $emailService->setEmEmail(trim($this->getRequest()->getPost()->get('id_situacao')));
        #Alysson - Verifica se já existe este emaill cadastrado para um usuário
        if ($emailService->filtrarObjeto()->count()) {
            $this->addErrorMessage('Email já cadastrado. Faça seu login.');
           $this->redirect()->toRoute('navegacao', array('controller' => 'catequista-catequista', 'action' => 'index'));
            return FALSE;
        }
           $resultEmail = parent::gravar(
                $this->getServiceLocator()->get('\Email\Service\EmailService'), new \Email\Form\EmailForm()
            );
      //##############################################################################################
        //GRAVANDO CATEQUISTA

    if($resultEmail){
      
        
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
                $this->getRequest()->getPost()->set('nr_telefone', \Estrutura\Helpers\Telefone::getTelefone($this->getRequest()->getPost()->get('id_telefone_celular')));
                $this->getRequest()->getPost()->set('id_tipo_telefone', $this->getConfigList()['tipo_telefone_celular']);
                $this->getRequest()->getPost()->set('id_situacao', $this->getConfigList()['situacao_ativo']);
                $resultTelefoneCelular = parent::gravar(
                    $this->getServiceLocator()->get('\Telefone\Service\TelefoneService'), new \Telefone\Form\TelefoneForm()
                );
                if($resultTelefoneCelular){
                    # Grava os dados do Endereco e retorna o ID do Endereco
                    $cidade =  new \Cidade\Service\CidadeService();
                    $id_cidade = $cidade->getIdCidadePorNomeToArray($this->getRequest()->getPost()->get('nm_cidade'));
                    $this->getRequest()->getPost()->set('id_cidade', $id_cidade['id_cidade']);
                    $this->getRequest()->getPost()->set('nr_cep', \Estrutura\Helpers\Cep::cepFilter($this->getRequest()->getPost()->get('nr_cep')));
                    $idEndereco = parent::gravar(
                        $this->getServiceLocator()->get('\Endereco\Service\EnderecoService'),new \Endereco\Form\EnderecoForm()
                    );
                
      
                
                if($idEndereco){
                  
                    
###################Cadastro Usuario ainda nao implementado###################################
         #$this->getRequest()->getPost()->set('nm_usuario', $this->getRequest()->getPost()->get('nm_usuario'));
         #$this->getRequest()->getPost()->set('id_email', $resultEmail);
         #$this->getRequest()->getPost()->set('id_sexo', $this->getRequest()->getPost()->get('id_sexo'));
         #$this->getRequest()->getPost()->set('id_endereco', $idEndereco);
         #$this->getRequest()->getPost()->set('id_telefone', $resultTelefoneCelular);
                    
                # $resultUsuario = parent::gravar(
                 #       $this->getServiceLocator()->get('\Usuario\ServiceUsuarioService'),new \Usuario\Form\UsuarioForm()
                  #  );     
                 #if($resultUsuario){
 #################################################################################################################                  
                       
              #Resgatando id de cidade e atribuindo ao campo id_naturalidade do cadastro de catequista.
           $id_naturalidade =  $cidade->getIdCidadePorNomeToArray($this->getRequest()->getPost()->get('nm_naturalidade'));
           $this->getRequest()->getPost()->set('id_naturalidade',$id_naturalidade['id_cidade']);
               
  // INSERINDO CAMPOS COM FKS DA TABELA CATEQUISTA 
       #$this->getRequest()->getPost()->set('id_usuario', $this->getRequest()->getPost()->get('id_usuario'));
       $this->getRequest()->getPost()->set('id_endereco', $idEndereco);
       $this->getRequest()->getPost()->set('id_sexo', $this->getRequest()->getPost()->get('id_sexo'));
        
        $this->getRequest()->getPost()->set('id_email', $resultEmail);
         $this->getRequest()->getPost()->set('id_telefone_residencial', $resultTelefoneResidencial);
         $this->getRequest()->getPost()->set('id_telefone_celular', $resultTelefoneCelular);
        $this->getRequest()->getPost()->set('id_situacao', $this->getRequest()->getPost()->get('id_situacao'));
        $this->getRequest()->getPost()->set('id_detalhe_formacao', $this->getRequest()->getPost()->get('id_detalhe_formacao'));
        
        ///INSERINDO CAMPOS DA TABELA CATEQUISTA
        $this->getRequest()->getPost()->set('nm_catequista', $this->getRequest()->getPost()->get('nm_catequista'));
        $this->getRequest()->getPost()->set('nr_matricula', $this->getRequest()->getPost()->get('nr_matricula'));
        $this->getRequest()->getPost()->set('dt_nascimento', $dataNascimento);
        $this->getRequest()->getPost()->set('dt_ingresso', $dataIngresso);
        $this->getRequest()->getPost()->set('tx_observacao', $this->getRequest()->getPost()->get('tx_observacao'));
       # $this->getRequest()->getPost()->set('ds_situacao', $this->getRequest()->getPost()->get('ds_situacao'));
       # $this->getRequest()->getPost()->set('cs_coodenador', $this->getRequest()->getPost()->get('cs_coordenador'));
        
        //GRAVANDO CAMPOS CATEQUISTA,PARAMETRO (FORMULARIO ALTERNATIVO SEM COMBOS)
           $resultCatequista= parent::gravar(
                            $this->getServiceLocator()->get('\Catequista\Service\CatequistaService'), new \Catequista\Form\CatequistaDetalheForm()
            );
           
     
           
            if($resultCatequista){
                                #Resgatando e inserindo manualmente na tabela catequista_etapa_atuacao as ids das etapas ja realizadas.
                                $arrEtapa =  $this->getRequest()->getPost()->get('arrEtapa');
                                foreach($arrEtapa as $etapa){
                                    $this->getRequest()->getPost()->set('id_etapa', $etapa);
                                    $this->getRequest()->getPost()->set('id_catequista', $resultCatequista);
                                    $this->getRequest()->getPost()->set('dt_cadastro', date('Y-m-d H:m:s'));
                                    #Chamo o metodo para gravar os dados na tabela.
                                    parent::gravar(
                                        $this->getServiceLocator()->get('\CatequistaEtapaAtuacao\Service\CatequistaEtapaAtuacaoService'), new \CatequistaEtapaAtuacao\Form\CatequistaEtapaAtuacaoForm()
                            );
                            
                                }
                                $status = true;
                            }
                        
                }}
                }
            
           if ($status ) {
               $this->addSuccessMessage('Parabéns! Catequizando cadastrado com sucesso.');
               $this->redirect()->toRoute('navegacao', array('controller' => 'catequista-catequista', 'action' => 'index'));
           }
            else{
                $this->addErrorMessage('Processo não pode ser concluido.');
                $this->redirect()->toRoute('navegacao', array('controller' => 'catequista-catequista', 'action' => 'cadastro'));
            }
    }}
   
           
           
           
           
           
    
   

  public function cadastroAction()
    { // funnção alterar
        return parent::cadastro($this->service, $this->form);
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
            $obcatequista=  new \Catequista\Service\CatequistaService();
            $arrCatequista =$obcatequista->getCatequistaToArray($id);
        

         ##############Excluindo dados da tabela filha###############
            $obCatequistaTurmaService = new \CatequistaTurma\Service\CatequistaTurmaService();
            $obCatequistaTurmaService->setIdCatequista($id);
            $obCatequistaTurmaService->excluir();
            
            $obCatequistaEtapaAtuacaoService = new \CatequistaEtapaAtuacao\Service\CatequistaEtapaAtuacaoService();
            $obCatequistaEtapaAtuacaoService->setIdCatequista($id);
            $obCatequistaEtapaAtuacaoService->excluir();
           
    
            
           $obCatequistaService = new \Catequista\Service\CatequistaService();
           $obCatequistaService->setIdCatequista($id);
           $obCatequistaService->excluir();
            
           $obEnderecoService = new \Endereco\Service\EnderecoService();
           $obEnderecoService->setIdCatequista($id);
           $obEnderecoService->excluir();
            
           $obTelResidencial =  new \Telefone\Service\TelefoneService();
           $obTelResidencial->setId($arrCatequisando['id_telefone_residencial']);
           $obTelResidencial->excluir();
            
           $obTelCelular =  new \Telefone\Service\TelefoneService();
           $obTelCelular->setId($arrCatequisando['id_telefone_celular']);
           $obTelCelular->excluir();
        
           $objEmail = new \Email\Service\EmailService();
           $objEmail->setId($arrCatequisando['id_email']);
           $objEmail->excluir();
    
        }}
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
