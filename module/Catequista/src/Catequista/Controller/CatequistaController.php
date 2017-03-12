<?php

namespace Catequista\Controller;

use Cidade\Service\CidadeService;
use DOMPDFModule\View\Model\PdfModel;
use Estrutura\Helpers\Cep;
use Estrutura\Controller\AbstractCrudController;
use Estrutura\Helpers\Cript;
use Estrutura\Helpers\Data;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Infra;

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
        #$dateNascimento = \DateTime::createFromFormat('d/m/Y', $this->getRequest()->getPost()->get('dt_nascimento'));
        #$dateIngresso = \DateTime::createFromFormat('d/m/Y', $this->getRequest()->getPost()->get('dt_ingresso'));
        $dataNascimento = Data::converterDataHoraBrazil2BancoMySQL($this->getRequest()->getPost()->get('dt_nascimento'));
        $dataIngresso = Data::converterDataHoraBrazil2BancoMySQL($this->getRequest()->getPost()->get('dt_ingresso'));

        ###########################- GRAVANDO EMAIL -#######################################################################

        $controller = $this->params('controller');
        $id_catequista = Cript::dec($this->getRequest()->getPost()->get('id'));

        $post = $this->getRequest()->getPost()->toArray();
        #$arrc = $this->service->buscar(Cript::dec($pos['id']))->toArray();

        if (isset($id_catequista) && $id_catequista) {
            $this->atualizarAction();
            return FALSE;
        }

        /* @var $emailService \Email\Service\EmailService */
        $emailService = $this->getServiceLocator()->get('\Email\Service\EmailService');
        $emailService->setEmEmail(trim($this->getRequest()->getPost()->get('em_email')));

        if ($emailService->filtrarObjeto()->count()) {

            $this->addErrorMessage('Email já cadastrado. Faça seu login.');
            $this->redirect()->toRoute('navegacao', array('controller' => 'catequista-catequista', 'action' => 'cadastro'));
            return FALSE;
        }


        //Verifica tamanho da senha
        if (strlen(trim($this->getRequest()->getPost()->get('pw_senha'))) < 8) {
            $this->addErrorMessage('Senha deve ter no mínimo 8 caracteres.');
            $this->redirect()->toRoute('navegacao', array('controller' => 'catequista-catequista', 'action' => 'cadastro'));
            return FALSE;
        }

        //Verifica se as novas senhas são iguais
        if (strcasecmp($this->getRequest()->getPost()->get('pw_senha'), $this->getRequest()->getPost()->get('pw_senha_confirm')) != 0) {
            $this->addErrorMessage('Senhas não correspondem.');
            $this->redirect()->toRoute('navegacao', array('controller' => 'catequista-catequista', 'action' => 'cadastro'));
            return FALSE;
        }


        # Realizando Tratamento do Telefone Residencial
        $this->getRequest()->getPost()->set('nr_ddd_telefone', \Estrutura\Helpers\Telefone::getDDD($this->getRequest()->getPost()->get('telefone_residencial')));
        $this->getRequest()->getPost()->set('nr_telefone', \Estrutura\Helpers\Telefone::getTelefone($this->getRequest()->getPost()->get('telefone_residencial')));
        $this->getRequest()->getPost()->set('id_tipo_telefone', $this->getConfigList()['tipo_telefone_residencial']);
        $this->getRequest()->getPost()->set('id_situacao', $this->getConfigList()['situacao_ativo']);
        $resultTelefoneResidencial = parent::gravar(
            $this->getServiceLocator()->get('\Telefone\Service\TelefoneService'), new \Telefone\Form\TelefoneForm()
        );
        if ($resultTelefoneResidencial) {
            # REalizando Tratamento do  Telefone Celular
            $this->getRequest()->getPost()->set('nr_ddd_telefone', \Estrutura\Helpers\Telefone::getDDD($this->getRequest()->getPost()->get('telefone_celular')));
            $this->getRequest()->getPost()->set('nr_telefone', \Estrutura\Helpers\Telefone::getTelefone($this->getRequest()->getPost()->get('telefone_celular')));
            $this->getRequest()->getPost()->set('id_tipo_telefone', $this->getConfigList()['tipo_telefone_celular']);
            $this->getRequest()->getPost()->set('id_situacao', $this->getConfigList()['situacao_ativo']);
            $resultTelefoneCelular = parent::gravar(
                $this->getServiceLocator()->get('\Telefone\Service\TelefoneService'), new \Telefone\Form\TelefoneForm()
            );
            if ($resultTelefoneCelular) {
                # Grava os dados do Endereco e retorna o ID do Endereco
                $cidade = new CidadeService();
                $id_cidade = $cidade->getIdCidadePorNomeToArray($this->getRequest()->getPost()->get('nm_cidade'));
                $this->getRequest()->getPost()->set('id_cidade', $id_cidade['id_cidade']);
                $this->getRequest()->getPost()->set('nr_cep', \Estrutura\Helpers\Cep::cepFilter($this->getRequest()->getPost()->get('nr_cep')));
                $idEndereco = parent::gravar(
                    $this->getServiceLocator()->get('\Endereco\Service\EnderecoService'), new \Endereco\Form\EnderecoForm()
                );

                if ($idEndereco) {

                    $idEmail = parent::gravar(
                        $this->getServiceLocator()->get('\Email\Service\EmailService'), new \Email\Form\EmailForm()
                    );
                    if ($idEmail) {

                        #Resgatando id de cidade e atribuindo ao campo id_naturalidade do cadastro de catequizando.
                        $id_naturalidade = $cidade->getIdCidadePorNomeToArray($this->getRequest()->getPost()->get('nm_naturalidade'));
                        $this->getRequest()->getPost()->set('id_naturalidade', $id_naturalidade['id_cidade']);
                        ###################Cadastro Usuario ainda nao implementado###################################
                        $this->getRequest()->getPost()->set('dt_nascimento', $dataNascimento);
                        $this->getRequest()->getPost()->set('nm_usuario', $this->getRequest()->getPost()->get('nm_usuario'));
                        $this->getRequest()->getPost()->set('id_email', $idEmail);
                        $this->getRequest()->getPost()->set('id_sexo', $this->getRequest()->getPost()->get('id_sexo'));
                        $this->getRequest()->getPost()->set('id_endereco', $idEndereco);
                        $this->getRequest()->getPost()->set('id_email', $idEmail);
                        $this->getRequest()->getPost()->set('nm_funcao', 'Catequista');
                        $this->getRequest()->getPost()->set('id_perfil', 2); //Perfil Professor
                        $this->getRequest()->getPost()->set('id_telefone', $resultTelefoneCelular);
                        $this->getRequest()->getPost()->set('id_tipo_usuario', $this->getRequest()->getPost()->get('id_tipo_usuario'));
                        $this->getRequest()->getPost()->set('id_situacao_usuario', $this->getRequest()->getPost()->get('id_situacao_usuario'));

                        $resultUsuario = parent::gravar(
                            $this->getServiceLocator()->get('\Usuario\Service\UsuarioService'), new \Usuario\Form\UsuarioForm()
                        );

                        if ($resultUsuario) {

                            $this->getRequest()->getPost()->set('id_usuario', $resultUsuario);
                            //Verifica se é dia 29, 30, 31
                            $this->getRequest()->getPost()->set('dt_registro', (date('Y-m-d H:m:s')));
                            $this->getRequest()->getPost()->set('id_perfil', $this->getRequest()->getPost()->get('id_perfil'));
                            $this->getRequest()->getPost()->set('pw_senha', md5($this->getRequest()->getPost()->get('pw_senha')));
                            $this->getRequest()->getPost()->set('id_situacao', $this->getRequest()->getPost()->get('id_situacao'));

                            $resultLogin = parent::gravar(
                                $this->getServiceLocator()->get('\Login\Service\LoginService'), new \Login\Form\LoginForm()
                            );

                            #################################################################################################################
                            if ($resultLogin) {

                                if (!empty($idEmail) && $idEmail) {

                                    #Resgatando id de cidade e atribuindo ao campo id_naturalidade do cadastro de catequista.
                                    $id_naturalidade = $cidade->getIdCidadePorNomeToArray($this->getRequest()->getPost()->get('nm_naturalidade'));
                                    $this->getRequest()->getPost()->set('id_naturalidade', $id_naturalidade['id_cidade']);

                                    // INSERINDO CAMPOS COM FKS DA TABELA CATEQUISTA
                                    $this->getRequest()->getPost()->set('id_usuario', $resultUsuario);
                                    $this->getRequest()->getPost()->set('id_endereco', $idEndereco);
                                    $this->getRequest()->getPost()->set('id_sexo', $this->getRequest()->getPost()->get('id_sexo'));

                                    $this->getRequest()->getPost()->set('id_email', $idEmail);
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
                                    $this->getRequest()->getPost()->set('ds_situacao', $this->getRequest()->getPost()->get('ds_situacao'));
                                    $this->getRequest()->getPost()->set('cs_coodenador', $this->getRequest()->getPost()->get('cs_coordenador'));

                                    //GRAVANDO CAMPOS CATEQUISTA,PARAMETRO (FORMULARIO ALTERNATIVO SEM COMBOS)
                                    $resultCatequista = parent::gravar(
                                        $this->getServiceLocator()->get('\Catequista\Service\CatequistaService'), new \Catequista\Form\CatequistaDetalheForm()
                                    );


                                    if ($resultCatequista) {
                                        #Resgatando e inserindo manualmente na tabela catequista_etapa_atuacao as ids das etapas ja realizadas.
                                        $arrEtapa = $this->getRequest()->getPost()->get('arrEtapa');
                                        foreach ($arrEtapa as $etapa) {
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

                                }
                            }
                        }

                        if ($status) {
                            $this->addSuccessMessage('Parabéns! Catequista cadastrado com sucesso.');
                            $this->redirect()->toRoute('navegacao', array('controller' => 'catequista-catequista', 'action' => 'index'));
                        } else {
                            $this->addErrorMessage('Processo não pode ser concluido.');
                            $this->redirect()->toRoute('navegacao', array('controller' => 'catequista-catequista', 'action' => 'cadastro'));
                        }
                    }
                }
            }
        }
    }


    public function cadastroAction()
    {
        $id = \Estrutura\Helpers\Cript::dec($this->params('id'));


        if (isset($id) && $id) {
            $arrCatequista = $this->service->buscar($id)->toArray();

            ###################### BUSCANDO INFORMAÇÕES DO CATEQUIZANDO ######################
            ## Recuperando Email

            $objEmail = new \Email\Service\EmailService();
            $email = $objEmail->buscar($arrCatequista['id_email'])->toArray();

            $objUsuario = new \Usuario\Service\UsuarioService();
            $usuario = $objUsuario->buscar($arrCatequista['id_usuario'])->toArray();


            $obLogin = new \Login\Service\LoginService();
            $login = $obLogin->getLoginToArray($arrCatequista['id_usuario']);


            ## Recuperando Endereco
            $objEnd = new \Endereco\Service\EnderecoService();
            $endereco = $objEnd->buscar($arrCatequista['id_endereco'])->toArray();

            ## Recuperando Cidade
            $objCidade = new \Cidade\Service\CidadeService();
            $cidade = $objCidade->buscar($endereco['id_cidade'])->toArray();

            ## Recuperar Estado da Cidade
            $objEstado = new \Estado\Service\EstadoService();
            $estadoCidade = $objEstado->buscar($cidade['id_estado'])->toArray();

            ## Recuperando Naturalidade
            $naturalidade = $objCidade->buscar($arrCatequista['id_naturalidade'])->toArray();

            ## Recuperar Estado da Naturalidade
            $objEstado = new \Estado\Service\EstadoService();
            $estadoNat = $objEstado->buscar($naturalidade['id_estado'])->toArray();

            ## Telefone Residencial
            $objTelefone = new \Telefone\Service\TelefoneService();
            $telResidencial = $objTelefone->buscar($arrCatequista['id_telefone_residencial'])->toArray();

            ## Telefone Celular
            $telCelular = $objTelefone->buscar($arrCatequista['id_telefone_celular'])->toArray();

            ## Recuperando Etapas que o Catequista já realizou
            $obCatequistaEtapaAtuacao = new \CatequistaEtapaAtuacao\Service\CatequistaEtapaAtuacaoService();
            $etapas = $obCatequistaEtapaAtuacao->select('id_catequista = ' . $id)->toArray();

            $etapa = [];
            foreach ($etapas as $e) {
                $etapa[] = $e['id_etapa'];
            }


            ############### POPULANDO O FORMULÁRIO DO CATEQUISta COM AS INFORMAÇÕES RESGATADAS ###########
            $this->getRequest()->getPost()->set('em_email', $email['em_email']);
            $this->getRequest()->getPost()->set('nm_usuario', $usuario['nm_usuario']);

            #x($this->getRequest()->getPost()->set('pw_a_senha', $login['pw_senha']));

            $this->getRequest()->getPost()->set('nm_logradouro', $endereco['nm_logradouro']);
            $this->getRequest()->getPost()->set('nm_bairro', $endereco['nm_bairro']);
            $this->getRequest()->getPost()->set('nm_complemento', $endereco['nm_complemento']);
            $this->getRequest()->getPost()->set('nr_numero', $endereco['nr_numero']);
            $this->getRequest()->getPost()->set('nr_cep', \Estrutura\Helpers\Cep::cepMask($endereco['nr_cep']));
            $this->getRequest()->getPost()->set('nm_cidade', $cidade['nm_cidade'] . " (" . $estadoCidade['sg_estado'] . ")");
            $this->getRequest()->getPost()->set('nm_naturalidade', $naturalidade['nm_cidade'] . " (" . $estadoNat['sg_estado'] . ")");
            $this->getRequest()->getPost()->set('telefone_residencial', \Estrutura\Helpers\Telefone::telefoneFilter($telResidencial['nr_ddd_telefone'] . $telResidencial['nr_telefone']));
            $this->getRequest()->getPost()->set('telefone_celular', ($telCelular['nr_ddd_telefone'] . $telCelular['nr_telefone']));

            $options = array();

            $options['arrEtapa'] = $etapa;


            $form = new \Catequista\Form\CatequistaDetalheForm($options);
            #x($options);
            x($arrCatequista);
            $form->setData($arrCatequista);
            $form->setData($this->getRequest()->getPost());

            $dadosView = [
                'service' => $this->service,
                'form' => $form,
                'controller' => $this->params('controller'),
                'atributos' => ''
            ];

            return new ViewModel($dadosView);


        }

        return parent::cadastro($this->service, $this->form);

    }

    public function excluirAction($option = null)
    {
        #xd($option);
        #ID_CATEQUISTA
        $id = Cript::dec($this->params('id'));
        if (!empty($option)) {
            $id = Cript::dec($option);
        }
        if (isset($id) && $id) {
            $obcatequista = new \Catequista\Service\CatequistaService();
            $arrCatequista = $obcatequista->getCatequistaToArray($id);


            ##############Excluindo dados da tabela filha###############
            $obCatequistaEtapaAtuacaoService = new \CatequistaEtapaAtuacao\Service\CatequistaEtapaAtuacaoService();
            $obCatequistaEtapaAtuacaoService->setIdCatequista($arrCatequista['id_catequista']);
            $obCatequistaEtapaAtuacaoService->excluir();

            $obCatequistaTurmaService = new \CatequistaTurma\Service\CatequistaTurmaService();
            $obCatequistaTurmaService->setIdCatequista($arrCatequista['id_catequista']);
            $obCatequistaTurmaService->excluir();

            $retornoExcluir = parent::excluir($this->service, $this->form);

            #Excluindo dados da tabela -  email
            $objEmail = new \Email\Service\EmailService();
            $objEmail->setId($arrCatequista['id_email']);
            $objEmail->excluir();

            #Excluindo dados da tabela - Telefone
            $obTelResidencial = new \Telefone\Service\TelefoneService();
            $obTelResidencial->setId($arrCatequista['id_telefone_residencial']);
            $obTelResidencial->excluir();

            #Excluindo dados da tabela - Telefone
            $obTelCelular = new \Telefone\Service\TelefoneService();
            $obTelCelular->setId($arrCatequista['id_telefone_celular']);
            $obTelCelular->excluir();

            #Excluindo dados da tabela - Endereco
            $obEndereco = new \Endereco\Service\EnderecoService();
            $obEndereco->setId($arrCatequista['id_endereco']);
            $obEndereco->excluir();
        }

        return $retornoExcluir;


    }

    public function indexPaginationAction()
    {// funcao paginacao
        //http://igorrocha.com.br/tutorial-zf2-parte-9-paginacao-busca-e-listagem/4/

        $filter = $this->getFilterPage();

        $camposFilter = [
            '0' => NULL,
            '1' => [
                'filter' => "catequista.nm_catequista LIKE ?",
            ],
            '2' => [
                'filter' => "catequista.nr_matricula LIKE ?",
            ],
            '3' => [
                'filter' => "catequista.dt_nascimento LIKE ?",
            ],
            '4' => [
                'filter' => "catequista.dt_ingresso LIKE ?",
            ],
            '5' => [
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

    public function atualizarAction()
    {

        $controller = $this->params('controller');
        try {
            $post = $this->getRequest()->getPost()->toArray();
            $id = Cript::dec($post['id']);
            $post['id'] = $id;
            $arr = $this->service->buscar($id)->toArray();

            ### Modificando o formato da data de nascimento para inserir no banco de dados.
            x($post['dt_nascimento'] = Data:: converterDataHoraBrazil2BancoMySQL($post['dt_nascimento']));
            $post['dt_ingresso'] = Data:: converterDataHoraBrazil2BancoMySQL($post['dt_ingresso']);
            ### Atualizando Email;


#x($post);
            $objUsuario = new \Usuario\Service\UsuarioService();
            $objUsuario->setId($arr['id_usuario']);
            $objUsuario->setNmUsuario($post['nm_usuario']);

            $objUsuario->salvar();
            ##################################################### login######################

            $loginService = new \Login\Service\LoginService();
            $log = $loginService->getLoginToArray($arr['id_usuario']);

            if ($post['pw_a_senha'] == '') {


                $loginService->setId($log['id_login']);
                $loginService->setPwSenha($log['pw_senha']);
                $ConfimSenha = $loginService->salvar();


            } else {

                if ($log['pw_senha'] != md5($post['pw_a_senha'])) {

                    $this->addErrorMessage("Senha atual inválida");
                    $this->redirect()->toRoute('navegacao', ['controller' => 'catequista-catequista', 'action' => 'index']);

                } else {

                    $loginService->setId($log['id_login']);
                    $loginService->setPwSenha(md5($post['pw_senha']));
                    $ConfimSenha = $loginService->salvar();


                }
            }

            if ($ConfimSenha) {


                $objEmail = new \Email\Service\EmailService();
                $objEmail->setId($arr['id_email']);
                $objEmail->setEmEmail($post['em_email']);
                $objEmail->salvar();

                ### Atualizando Telefone Residencial
                $objTelefone = new \Telefone\Service\TelefoneService();
                $objTelefone->setId($arr['id_telefone_residencial']);
                $telefone = \Estrutura\Helpers\Telefone::telefoneMask($post['telefone_residencial']);
                $objTelefone->setNrDddTelefone(\Estrutura\Helpers\Telefone::getDDD($telefone));
                $objTelefone->setNrTelefone(\Estrutura\Helpers\Telefone::getTelefone($telefone));
                #xd($objTelefone->getNrTelefone());
                $objTelefone->salvar();

                ### Atualizando Telefone Celular
                $objTelefone = new \Telefone\Service\TelefoneService();
                $objTelefone->setId($arr['id_telefone_celular']);
                $telefone = \Estrutura\Helpers\Telefone::telefoneMask($post['telefone_celular']);
                $objTelefone->setNrDddTelefone(\Estrutura\Helpers\Telefone::getDDD($telefone));
                $objTelefone->setNrTelefone(\Estrutura\Helpers\Telefone::getTelefone($telefone));
                $objTelefone->salvar();

                ### Atualizando Endereco
                $objEndereco = new \Endereco\Service\EnderecoService();
                $objEndereco->setId($arr['id_endereco']);
                $objEndereco->setNmLogradouro($post['nm_logradouro']);
                $objEndereco->setNmComplemento($post['nm_complemento']);
                $objEndereco->setNrNumero($post['nr_numero']);
                $objEndereco->setNrCep(Cep::cepFilter($post['nr_cep']));
                $objEndereco->setNmBairro($post['nm_bairro']);


## Recuperando id da Cidade
                $cidade = new CidadeService();
                $id_cidade = $cidade->getIdCidadePorNomeToArray($post['nm_cidade']);
                $objEndereco->setIdCidade($id_cidade['id_cidade']);
                $objEndereco->salvar();

                ## Recuperando id da Naturalidade
                $id_naturalidade = $cidade->getIdCidadePorNomeToArray($post['nm_naturalidade']);
                $post['id_naturalidade'] = $id_naturalidade['id_cidade'];


                ################################################################################################


                ## Atualizando Catequista Etapa Cursou
                $arrEtapa = $this->getRequest()->getPost()->get('arrEtapa');
                #x($arrEtapa);

                ## Excluindo dados Antigos
                $obEtapa = new \CatequistaEtapaAtuacao\Service\CatequistaEtapaAtuacaoService();
                $obEtapa->setIdCatequista($id);
                $obEtapa->excluir();

                ## Regravando Ctequisando Etapa Cursou  já realizado pelo Catequizando
                foreach ($arrEtapa as $etapa) {
                    $et = new \CatequistaEtapaAtuacao\Service\CatequistaEtapaAtuacaoService();
                    $et->setIdEtapa($etapa);
                    $et->setIdCatequista($id);
                    $et->salvar();
                }


                #x($post['dt_nascimento']);
                #xd($post);
                $form = new \Catequista\Form\CatequistaDetalheForm();
                $form->setData($post);

                $my_service = new \Catequista\Service\CatequistaService();
                $my_service->exchangeArray($post);

                $this->addSuccessMessage('Parabéns! Catequista cadastrado com sucesso.');
                $this->redirect()->toRoute('navegacao', array('controller' => $controller, 'action' => 'index'));

                return $my_service->salvar();;

            }
        } catch (\Exception $e) {

            $this->setPost($post);
            $this->addErrorMessage($e->getMessage());
            $this->redirect()->toRoute('navegacao', array('controller' => $controller, 'action' => 'cadastro'));
            return FALSE;
        }
    }


    public function atualizardadosAction()
    {
        $id = \Estrutura\Helpers\Cript::dec($this->params('id'));


        if (isset($id) && $id) {
            $arrCatequista = $this->service->buscar($id)->toArray();

            ###################### BUSCANDO INFORMAÇÕES DO CATEQUIZANDO ######################
            ## Recuperando Email

            $objEmail = new \Email\Service\EmailService();
            $email = $objEmail->buscar($arrCatequista['id_email'])->toArray();

            $objUsuario = new \Usuario\Service\UsuarioService();
            $usuario = $objUsuario->buscar($arrCatequista['id_usuario'])->toArray();


            $obLogin = new \Login\Service\LoginService();
            $login = $obLogin->getLoginToArray($arrCatequista['id_usuario']);


            ## Recuperando Endereco
            $objEnd = new \Endereco\Service\EnderecoService();
            $endereco = $objEnd->buscar($arrCatequista['id_endereco'])->toArray();

            ## Recuperando Cidade
            $objCidade = new \Cidade\Service\CidadeService();
            $cidade = $objCidade->buscar($endereco['id_cidade'])->toArray();

            ## Recuperar Estado da Cidade
            $objEstado = new \Estado\Service\EstadoService();
            $estadoCidade = $objEstado->buscar($cidade['id_estado'])->toArray();

            ## Recuperando Naturalidade
            $naturalidade = $objCidade->buscar($arrCatequista['id_naturalidade'])->toArray();

            ## Recuperar Estado da Naturalidade
            $objEstado = new \Estado\Service\EstadoService();
            $estadoNat = $objEstado->buscar($naturalidade['id_estado'])->toArray();

            ## Telefone Residencial
            $objTelefone = new \Telefone\Service\TelefoneService();
            $telResidencial = $objTelefone->buscar($arrCatequista['id_telefone_residencial'])->toArray();

            ## Telefone Celular
            $telCelular = $objTelefone->buscar($arrCatequista['id_telefone_celular'])->toArray();

            ## Recuperando Etapas que o Catequista já realizou
            $obCatequistaEtapaAtuacao = new \CatequistaEtapaAtuacao\Service\CatequistaEtapaAtuacaoService();
            $etapas = $obCatequistaEtapaAtuacao->select('id_catequista = ' . $id)->toArray();

            $etapa = [];
            foreach ($etapas as $e) {
                $etapa[] = $e['id_etapa'];
            }


            ############### POPULANDO O FORMULÁRIO DO CATEQUISta COM AS INFORMAÇÕES RESGATADAS ###########
            $this->getRequest()->getPost()->set('em_email', $email['em_email']);
            $this->getRequest()->getPost()->set('nm_usuario', $usuario['nm_usuario']);

            $this->getRequest()->getPost()->set('pw_senha', $login['pw_senha']);
            $this->getRequest()->getPost()->set('nm_logradouro', $endereco['nm_logradouro']);
            $this->getRequest()->getPost()->set('nm_bairro', $endereco['nm_bairro']);
            $this->getRequest()->getPost()->set('nm_complemento', $endereco['nm_complemento']);
            $this->getRequest()->getPost()->set('nr_numero', $endereco['nr_numero']);
            $this->getRequest()->getPost()->set('nr_cep', \Estrutura\Helpers\Cep::cepMask($endereco['nr_cep']));
            $this->getRequest()->getPost()->set('nm_cidade', $cidade['nm_cidade'] . " (" . $estadoCidade['sg_estado'] . ")");
            $this->getRequest()->getPost()->set('nm_naturalidade', $naturalidade['nm_cidade'] . " (" . $estadoNat['sg_estado'] . ")");
            $this->getRequest()->getPost()->set('telefone_residencial', \Estrutura\Helpers\Telefone::telefoneFilter($telResidencial['nr_ddd_telefone'] . $telResidencial['nr_telefone']));
            $this->getRequest()->getPost()->set('telefone_celular', ($telCelular['nr_ddd_telefone'] . $telCelular['nr_telefone']));

            $options = array();

            $options['arrEtapa'] = $etapa;


            $form = new \Catequista\Form\CatequistaDetalheForm($options);
            #x($options);
            #x($arrCatequista);
            $form->setData($arrCatequista);
            $form->setData($this->getRequest()->getPost());

            $dadosView = [
                'service' => $this->service,
                'form' => $form,
                'controller' => $this->params('controller'),
                'atributos' => ''
            ];

            return new ViewModel($dadosView);


        }

        return parent::atualizardados($this->service, $this->form);

    }

    public function gerarRelatorioPdfAction()
    {
        $catequizandoService = new \Catequizando\Service\CatequizandoService();
        $arteste = $catequizandoService->fetchAll()->toArray();
        $pdf = new PdfModel();
        $pdf->setVariables(array(
            'caminho_imagem' => __DIR__,
            'inicio_contador' => 3,
            'teste' => $arteste,

        ));
        $pdf->setOption('filename', 'ordem_serviço_'); // Triggers PDF download, automatically appends ".pdf"
        $pdf->setOption("paperSize", "a4"); //Defaults to 8x11
        $pdf->setOption("basePath", __DIR__); //Defaults to 8x11
        #$pdf->setOption("paperOrientation", "landscape"); //Defaults to portrait
        return $pdf;

    }


}



