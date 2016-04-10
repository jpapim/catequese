<?php

namespace Usuario\Controller;

use Estrutura\Controller\AbstractCrudController;
use Estrutura\Helpers\Cript;
use Zend\Filter\File\Encrypt;
use Zend\View\Model\ViewModel;

class UsuarioController extends AbstractCrudController {

    /**
     * @var \Usuario\Service\Usuario
     */
    protected $service;

    /**
     * @var \Usuario\Form\Usuario
     */
    protected $form;
    protected $camposPendencia = [
        'nm_estado',
        'nm_cidade',
        'nu_rg',
        'nu_cpf',
        'nm_profissao',
        'nm_estado_civil',
        'nm_nacionalidade',
        'nr_agencia',
        'id_banco',
        'nm_logradouro',
        'nr_numero',
        'nm_bairro',
        'nm_cidade',
        'nm_estado',
        'nr_cep',
    ];

    public function __construct()
    {
        parent::init();
    }

    public function indexAction()
    {
        return parent::index($this->service, $this->form);
    }

    /**
     * 
     * @return boolean
     */
    public function gravarAction()
    {

        $form = new \Usuario\Form\UsuarioForm();

        $elementCaptch = $form->getElements()['captcha'];
        foreach ($elementCaptch->getInputSpecification()['validators'] as $validator) {

            if (!$validator->isValid($this->getRequest()->getPost()->get('captcha'))) {

                $this->addErrorMessage('Captcha inválido.');
                $this->redirect()->toRoute('cadastro', array('id' => $this->getRequest()->getPost()->get('id_usuario_pai')));
                return FALSE;
            }
        }

        /* @var $emailService \Email\Service\EmailService */
        $emailService = $this->getServiceLocator()->get('\Email\Service\EmailService');
        $emailService->setEmEmail(trim($this->getRequest()->getPost()->get('em_email')));

        if ($emailService->filtrarObjeto()->count()) {

            $this->addErrorMessage('Email já cadastrado. Faça seu login.');
            $this->redirect()->toRoute('cadastro', array('id' => $this->getRequest()->getPost()->get('id_usuario_pai')));
            return FALSE;
        }

        $contratoService = $this->getServiceLocator()->get('\Contrato\Service\ContratoService');
        $contratoService->setIdUsuario($this->getRequest()->getPost()->get('id_usuario_pai'));
        $contratoOrigem = $contratoService->filtrarObjeto()->current();

        if (!$contratoOrigem) {

            $this->addErrorMessage('Link de cadastro inválido. Cadastre com outro link.');
            $this->redirect()->toRoute('cadastro', array('id' => $this->getRequest()->getPost()->get('id_usuario_pai')));
            return FALSE;
        }

        /* @var $UsuarioService \Usuario\Service\UsuarioService */
        $usuarioService = new \Usuario\Service\UsuarioService();
        $usuarioService->setNuCpf(\Estrutura\Helpers\Cpf::cpfFilter($this->getRequest()->getPost()->get('nu_cpf')));

        if ($usuarioService->filtrarObjeto()->count()) {

            $this->addErrorMessage('Cpf já cadastrado. Faça seu login.');
            $this->redirect()->toRoute('cadastro', array('id' => $this->getRequest()->getPost()->get('id_usuario_pai')));
            return FALSE;
        }

        $validatorCpf = new \Estrutura\Validator\Cpf();

        if (!$validatorCpf->isValid(\Estrutura\Helpers\Cpf::cpfFilter($this->getRequest()->getPost()->get('nu_cpf')))) {

            $this->addErrorMessage('Cpf inválido.');
            $this->redirect()->toRoute('cadastro', array('id' => $this->getRequest()->getPost()->get('id_usuario_pai')));
            return FALSE;
        }

        $dateNascimento = \DateTime::createFromFormat('d/m/Y', $this->getRequest()->getPost()->get('dt_nascimento'));
        $dataMaioridade = new \Datetime();
        $dataMaioridade->modify('-18 years');

        if ($dateNascimento > $dataMaioridade) {

            $this->addErrorMessage('Usuário deve ser maior de idade para se cadastrar.');
            $this->redirect()->toRoute('cadastro', array('id' => $this->getRequest()->getPost()->get('id_usuario_pai')));
            return FALSE;
        }

        //Verifica tamanho da senha
        if (strlen(trim($this->getRequest()->getPost()->get('pw_senha'))) < 8) {

            $this->addErrorMessage('Senha deve ter no mínimo 8 caracteres.');
            $this->redirect()->toRoute('cadastro', array('id' => $this->getRequest()->getPost()->get('id_usuario_pai')));
            return FALSE;
        }

        //Verifica se as novas senhas são iguais
        if (strcasecmp($this->getRequest()->getPost()->get('pw_senha'), $this->getRequest()->getPost()->get('pw_senha_confirm')) != 0) {

            $this->addErrorMessage('Senhas não correspondem.');
            $this->redirect()->toRoute('cadastro', array('id' => $this->getRequest()->getPost()->get('id_usuario_pai')));
            return FALSE;
        }

        $this->getRequest()->getPost()->set('nr_ddd_telefone', \Estrutura\Helpers\Telefone::getDDD($this->getRequest()->getPost()->get('nr_telefone')));
        $this->getRequest()->getPost()->set('nr_telefone', \Estrutura\Helpers\Telefone::getTelefone($this->getRequest()->getPost()->get('nr_telefone')));
        $this->getRequest()->getPost()->set('id_tipo_telefone', $this->getConfigList()['tipo_telefone_residencial']);
        $this->getRequest()->getPost()->set('id_situacao', $this->getConfigList()['situacao_ativo']);
        $resultTelefone = parent::gravar(
                        $this->getServiceLocator()->get('\Telefone\Service\TelefoneService'), new \Telefone\Form\TelefoneForm()
        );

        if ($resultTelefone) {

            $resultEmail = parent::gravar(
                            $this->getServiceLocator()->get('\Email\Service\EmailService'), new \Email\Form\EmailForm()
            );

            if ($resultEmail) {

                $this->getRequest()->getPost()->set('dt_nascimento', $dateNascimento->format('Y-m-d'));
                $this->getRequest()->getPost()->set('nu_cpf', \Estrutura\Helpers\Cpf::cpfFilter($this->getRequest()->getPost()->get('nu_cpf')));
                $this->getRequest()->getPost()->set('id_telefone', $resultTelefone);
                $this->getRequest()->getPost()->set('id_email', $resultEmail);
                $this->getRequest()->getPost()->set('id_tipo_usuario', $this->getConfigList()['tipo_usuario_aluno']);
                $this->getRequest()->getPost()->set('id_situacao_usuario', $this->getConfigList()['situacao_usuario_congelado']);

                $resultUsuario = parent::gravar(
                                $this->getServiceLocator()->get('\Usuario\Service\UsuarioService'), new \Usuario\Form\UsuarioForm()
                );

                if ($resultUsuario) {

                    $this->getRequest()->getPost()->set('id_usuario', $resultUsuario);
                    //Verifica se é dia 29, 30, 31
                    $this->getRequest()->getPost()->set('dt_registro', (date('d') >= 29 ? date('Y-m-' . 28 . ' H:m:s') : date('Y-m-d H:m:s')));
                    $this->getRequest()->getPost()->set('id_perfil', $this->getConfigList()['perfil_aluno']);
                    $this->getRequest()->getPost()->set('pw_senha', md5($this->getRequest()->getPost()->get('pw_senha')));
                    $this->getRequest()->getPost()->set('id_situacao', $this->getConfigList()['situacao_inativo']);

                    $resultLogin = parent::gravar(
                                    $this->getServiceLocator()->get('\Login\Service\LoginService'), new \Login\Form\LoginForm()
                    );

                    if ($resultLogin) {

                        $this->getRequest()->getPost()->set('id_situacao', $this->getConfigList()['situacao_ativo']);
                        $this->getRequest()->getPost()->set('dt_adesao', (date('d') >= 29 ? date('Y-m-' . 28 . ' H:m:s') : date('Y-m-d H:m:s')));
                        $this->getRequest()->getPost()->set('id_contrato_origem', $contratoOrigem->getId());

                        $resultContrato = parent::gravar(
                                        $this->getServiceLocator()->get('\Contrato\Service\ContratoService'), new \Contrato\Form\ContratoForm()
                        );

                        if ($resultContrato) {


                            $contaEmail = 'no-reply';

                            $message = new \Zend\Mail\Message();
                            $message->addFrom($contaEmail . '@mcnetwork.com.br', 'MC Network')
//                    @TODO
//                        ->addTo(trim($this->getRequest()->getPost()->get('em_email')))
                                    ->addTo('ronaldo.r.melo@gmail.com')
                                    ->addBcc('mcnetwork@mcnetwork.com.br')
                                    ->setSubject('Confirmação de cadastro');

                            $applicationService = new \Application\Service\ApplicationService();
                            $transport = $applicationService->getSmtpTranport($contaEmail);

                            $htmlMessage = $applicationService->tratarModelo(
                                    [
                                'BASE_URL' => BASE_URL,
                                'nomeUsuario' => trim($this->getRequest()->getPost()->get('nm_usuario')),
                                'txIdentificacao' => base64_encode(\Estrutura\Helpers\Bcrypt::hash($resultLogin)),
                                'email' => trim($this->getRequest()->getPost()->get('em_email')),
                                    ], $applicationService->getModelo('cadastro'));

                            $html = new \Zend\Mime\Part($htmlMessage);
                            $html->type = "text/html";

                            $body = new \Zend\Mime\Message();
                            $body->addPart($html);

                            $message->setBody($body);
                            $transport->send($message);

                            $this->addSuccessMessage('Parabéns! Cadastro realizado com sucesso. Para confirmar seu cadastro, leia as instruções que enviamos para você por e-mail.');
                            $this->getServiceLocator()->get('Auth\Table\MyAuth')->forgetMe();
                            $this->getServiceLocator()->get('AuthService')->clearIdentity();
                        }
                    }
                }
            }
        }

        $this->redirect()->toRoute('navegacao', array('controller' => 'auth', 'action' => 'login'));
    }

    /**
     * 
     * @return type
     */
    public function cadastroAction()
    {
        $usuarioService = new \Usuario\Service\UsuarioService();
        $form = new \Usuario\Form\UsuarioForm();

        $id_criptografado = $this->params('id') ? $this->params('id') : $this->getRequest()->getPost()->get('id');
        $id = Cript::dec($id_criptografado);

        #$usuario = $usuarioService->getUsuario($id);
        $usuario = $usuarioService->getUsuario(1);

        #print_r($usuario);
        #die;

        if ($usuario) {
            return parent::cadastro($usuarioService, $form, [
                        'id_usuario' => $id,
                        'usuario' => $usuario
            ]);
        } else {
            $this->flashmessenger()->addWarningMessage('Código do patrocinador inválido.');
            $this->redirect()->toRoute('navegacao', array('controller' => 'auth', 'action' => 'login'));
            return FALSE;
        }
    }

    /**
     * 
     * @return type
     */
    public function dadosPessoaisAction()
    {

        $auth = $this->getServiceLocator()->get('AuthService')->getStorage()->read();
        $usuarioService = new \Usuario\Service\UsuarioService();

        $usuario = $usuarioService->getUsuario($auth->id_usuario);

        $temPendenciaCadastral = FALSE;
        foreach ($usuario as $key => $value) {
            if (in_array($key, $this->camposPendencia) && !$value) {

                $temPendenciaCadastral = TRUE;
                break;
            }
        }

        /* @var $pagamentoService \Pagamento\Service\PagamentoService */
        $pagamentoService = $this->getServiceLocator()->get('\Pagamento\Service\PagamentoService');

        //Verifica se existem saques pendentes
        $saqueComReciboEnviadoList = $pagamentoService->getSaqueComReciboEnviado($auth);
        $temSaqueComReciboEnviado = FALSE;
        if ($saqueComReciboEnviadoList->count()) {

            $temSaqueComReciboEnviado = TRUE;
        }

        $view = new ViewModel([
            'controller' => $this->params('controller'),
            'usuario' => $usuario,
            'temPendenciaCadastral' => $temPendenciaCadastral,
            'temSaqueComReciboEnviado' => $temSaqueComReciboEnviado,
        ]);
        return $view->setTerminal(TRUE);
    }

    /**
     * 
     * @return ViewModel
     */
    public function atualizarDadosAction()
    {
        $auth = $this->getServiceLocator()->get('AuthService')->getStorage()->read();

        /* @var $pagamentoService \Pagamento\Service\PagamentoService */
        $pagamentoService = $this->getServiceLocator()->get('\Pagamento\Service\PagamentoService');

        //Verifica se existem saques pendentes
        $saqueComReciboEnviadoList = $pagamentoService->getSaqueComReciboEnviado($auth);
        $temSaqueComReciboEnviado = FALSE;
        if ($saqueComReciboEnviadoList->count()) {

            $temSaqueComReciboEnviado = TRUE;
        }

        $usuarioService = new \Usuario\Service\UsuarioService();
        $usuario = $usuarioService->getUsuario($auth->id_usuario);

        $usuario['nr_telefone'] = $usuario['nr_ddd_telefone'] . $usuario['nr_telefone'];
        $usuario['nr_cep'] = \Estrutura\Helpers\Cep::cepMask($usuario['nr_cep']);

        $form = new \Usuario\Form\AtualizaUsuarioForm();
        $form->setData($usuario);

        $post = $this->getPost();

        if (!empty($post)) {

            $form->setData($post);
        }

        /* @var $contratoService \Contrato\Service\ContratoService */
        $contratoService = $this->getServiceLocator()->get('\Contrato\Service\ContratoService');
        $contratoEntity = $contratoService->buscar($auth->id_contrato);

        $meusGanhosList = $pagamentoService->toArrayResult($pagamentoService->getMeusGanhos($auth));

        return new ViewModel([
            'configList' => $this->getConfigList(),
            'form' => $form,
            'controller' => $this->params('controller'),
            'usuario' => $usuario,
            'auth' => $auth,
            'contratoEntity' => $contratoEntity,
            'meusGanhosList' => $meusGanhosList,
            'temSaqueComReciboEnviado' => $temSaqueComReciboEnviado,
        ]);
    }

    /**
     * 
     * @return type
     */
    public function excluirAction()
    {
        return parent::excluir($this->service, $this->form);
    }

    /**
     * 
     * @return boolean
     * @throws \Exception
     */
    public function gravarAtualizacaoAction()
    {
        $controller = $this->params('controller');
        $request = $this->getRequest();


        if (!$request->isPost()) {
            throw new \Exception('Dados Inválidos');
        }

        $post = $request->getPost()->toArray();

        try {

            $auth = $this->getServiceLocator()->get('AuthService')->getStorage()->read();

            /* @var $pagamentoService \Pagamento\Service\PagamentoService */
            $pagamentoService = $this->getServiceLocator()->get('\Pagamento\Service\PagamentoService');

            //Verifica se existem saques pendentes
            $saqueComReciboEnviadoList = $pagamentoService->getSaqueComReciboEnviado($auth);
            if ($saqueComReciboEnviadoList->count()) {

                $this->flashmessenger()->addInfoMessage('Quando você envia um recibo de bônus, não é possível realizar atualizações cadastrais.');
                //$this->redirect()->toRoute('navegacao', array('controller' => 'mcnetwork-index', 'action' => 'index'));
                //Alysson
                $this->redirect()->toRoute('navegacao', array('controller' => 'usuario-usuario', 'action' => 'index'));
                return FALSE;
            }

            $usuarioService = new \Usuario\Service\UsuarioService();
            $usuarioEntity = $usuarioService->buscar($auth->id_usuario);

            $post['nu_cpf'] = $usuarioEntity->getNuCpf();

            $form = new \Usuario\Form\AtualizaUsuarioForm();
            $form->setData($post);

            if (!$form->isValid()) {

                $this->addValidateMessages($form);
                $this->setPost($post);
                $this->redirect()->toRoute('navegacao', array('controller' => $controller, 'action' => 'atualizar-dados'));
                return FALSE;
            }

            // Atualiza Telefone
            $formTelefone = new \Telefone\Form\TelefoneForm();
            $formTelefone->setData([
                'id' => $usuarioEntity->getIdTelefone(),
                'nr_ddd_telefone' => \Estrutura\Helpers\Telefone::getDDD($this->getRequest()->getPost()->get('nr_telefone')),
                'nr_telefone' => \Estrutura\Helpers\Telefone::getTelefone($this->getRequest()->getPost()->get('nr_telefone')),
                'id_tipo_telefone' => $this->getConfigList()['tipo_telefone_residencial'],
                'id_situacao' => $this->getConfigList()['situacao_ativo'],
            ]);

            if (!$formTelefone->isValid()) {
                $this->addValidateMessages($formTelefone);
                $this->setPost($post);
                $this->redirect()->toRoute('navegacao', array('controller' => $controller, 'action' => 'atualizar-dados'));
                return FALSE;
            }
            $telefoneService = $this->getServiceLocator()->get('\Telefone\Service\TelefoneService');
            $telefoneService->exchangeArray($formTelefone->getData());
            $telefoneService->salvar();

            // Atualiza Endereço
            $formEndereco = new \Endereco\Form\EnderecoForm();
            $formEndereco->setData([
                'id' => $usuarioEntity->getIdEndereco(),
                'nm_logradouro' => $this->getRequest()->getPost()->get('nm_logradouro'),
                'nr_numero' => $this->getRequest()->getPost()->get('nr_numero'),
                'nm_complemento' => $this->getRequest()->getPost()->get('nm_complemento'),
                'nm_bairro' => $this->getRequest()->getPost()->get('nm_bairro'),
                'nr_cep' => \Estrutura\Helpers\Cep::cepFilter($this->getRequest()->getPost()->get('nr_cep')),
                'id_cidade' => $this->getRequest()->getPost()->get('id_cidade'),
            ]);
            if (!$formEndereco->isValid()) {
                $this->addValidateMessages($formEndereco);
                $this->setPost($post);
                $this->redirect()->toRoute('navegacao', array('controller' => $controller, 'action' => 'atualizar-dados'));
                return FALSE;
            }
            $enderecoService = $this->getServiceLocator()->get('\Endereco\Service\EnderecoService');
            $enderecoService->exchangeArray($formEndereco->getData());
            $enderecoService->salvar();

            //Atualiza dados usuario
            $usuarioEntity->setNuRg(\Estrutura\Helpers\Cpf::cpfFilter($this->getRequest()->getPost()->get('nu_rg')));
            $usuarioEntity->setNuCpf(\Estrutura\Helpers\Cpf::cpfFilter($post['nu_cpf']));
            $usuarioEntity->setNmProfissao($this->getRequest()->getPost()->get('nm_profissao'));
            $usuarioEntity->setNmNacionalidade($this->getRequest()->getPost()->get('nm_nacionalidade'));
            $usuarioEntity->setIdSexo($this->getRequest()->getPost()->get('id_sexo'));
            $usuarioEntity->setIdEstado_civil($this->getRequest()->getPost()->get('id_estado_civil'));
            $usuarioEntity->setIdEndereco($enderecoService->getId());
            $usuarioEntity->salvar();

            /* @var $contaBancariaService \ContaBancaria\Service\ContaBancariaService */
            $contaBancariaService = $this->getServiceLocator()->get('\ContaBancaria\Service\ContaBancariaService');
            $contaBancariaEntity = $contaBancariaService->getContaBancaria($auth);

            $formContaBancaria = new \ContaBancaria\Form\ContaBancariaForm();
            $formContaBancaria->setData([
                'id' => $contaBancariaEntity ? $contaBancariaEntity['id_conta_bancaria'] : NULL,
                'nr_agencia' => \Estrutura\Helpers\Cnpj::cnpjFilter($this->getRequest()->getPost()->get('nr_agencia')),
                'nr_conta' => \Estrutura\Helpers\Cnpj::cnpjFilter($this->getRequest()->getPost()->get('nr_conta')),
                'id_situacao' => $this->getConfigList()['situacao_ativo'],
                'id_usuario' => $usuarioEntity->getId(),
                'id_banco' => $this->getRequest()->getPost()->get('id_banco'),
                'id_tipo_conta' => $this->getRequest()->getPost()->get('id_tipo_conta'),
            ]);
            if (!$formContaBancaria->isValid()) {
                $this->addValidateMessages($formContaBancaria);
                $this->setPost($post);
                $this->redirect()->toRoute('navegacao', array('controller' => $controller, 'action' => 'atualizar-dados'));
                return FALSE;
            }
            $contaBancariaService->exchangeArray($formContaBancaria->getData());
            $contaBancariaService->salvar();

            $this->flashmessenger()->addSuccessMessage('Dados atualizado com sucesso.');
//            $this->redirect()->toRoute('navegacao', array('controller' => 'mcnetwork-index', 'action' => 'index'));
            //Alysson
            $this->redirect()->toRoute('navegacao', array('controller' => 'usuario-usuario', 'action' => 'index'));
            return TRUE;
        } catch (\Exception $e) {

            $this->setPost($post);
            $this->addErrorMessage($e->getMessage());
            $this->redirect()->toRoute('navegacao', array('controller' => $controller, 'action' => 'atualizar-dados'));
            return FALSE;
        }
    }

    /**
     * 
     * @return ViewModel
     */
    public function alterarSenhaAction()
    {

        $auth = $this->getServiceLocator()->get('AuthService')->getStorage()->read();

        $usuarioService = new \Usuario\Service\UsuarioService();
        $usuarioEntity = $usuarioService->buscar($auth->id_usuario);

        /* @var $contratoService \Contrato\Service\ContratoService */
        $contratoService = $this->getServiceLocator()->get('\Contrato\Service\ContratoService');
        $contratoEntity = $contratoService->buscar($auth->id_contrato);

        /* @var $pagamentoService \Pagamento\Service\PagamentoService */
        $pagamentoService = $this->getServiceLocator()->get('\Pagamento\Service\PagamentoService');
        $meusGanhosList = $pagamentoService->toArrayResult($pagamentoService->getMeusGanhos($auth));

        return new ViewModel([
            'configList' => $this->getConfigList(),
            'form' => new \Auth\Form\RedefinirSenhaForm(),
            'controller' => $this->params('controller'),
            'usuarioEntity' => $usuarioEntity,
            'auth' => $auth,
            'contratoEntity' => $contratoEntity,
            'meusGanhosList' => $meusGanhosList,
        ]);
    }

    /**
     * 
     */
    public function salvarRedefinicaoSenhaAction()
    {

        $auth = $this->getServiceLocator()->get('AuthService')->getStorage()->read();

        $form = new \Auth\Form\RedefinirSenhaForm();

        $elementCaptch = $form->getElements()['captcha'];
        foreach ($elementCaptch->getInputSpecification()['validators'] as $validator) {

            if (!$validator->isValid($this->getRequest()->getPost()->get('captcha'))) {

                $this->addErrorMessage('Captcha inválido.');
                $this->redirect()->toRoute('navegacao', ['controller' => 'usuario-usuario', 'action' => 'alterar-senha']);
                return FALSE;
            }
        }

        $loginService = new \Login\Service\LoginService();
        $loginService->setIdUsuario($auth->id_usuario);
        $loginEntity = $loginService->filtrarObjeto()->current();

        if (!$loginEntity) {

            $this->addErrorMessage('Usuario inválido.');
            $this->redirect()->toRoute('navegacao', ['controller' => 'usuario-usuario', 'action' => 'alterar-senha']);
            return FALSE;
        }

        //Verifica tamanho da senha
        if (strlen(trim($this->getRequest()->getPost()->get('pw_nova_senha'))) < 8) {

            $this->addErrorMessage('Senha deve ter no mínimo 8 caracteres.');
            $this->redirect()->toRoute('navegacao', ['controller' => 'usuario-usuario', 'action' => 'alterar-senha']);
            return FALSE;
        }

        //Verifica se a senha atual é válida
        if (strcasecmp(md5($this->getRequest()->getPost()->get('pw_senha')), $loginEntity->getPwSenha()) != 0) {

            $this->addErrorMessage('Senha atual inválida.');
            $this->redirect()->toRoute('navegacao', ['controller' => 'usuario-usuario', 'action' => 'alterar-senha']);
            return FALSE;
        }

        //Verifica se as novas senhas são iguais
        if (strcasecmp($this->getRequest()->getPost()->get('pw_nova_senha_confirm'), $this->getRequest()->getPost()->get('pw_nova_senha')) != 0) {

            $this->addErrorMessage('Senhas não correspondem.');
            $this->redirect()->toRoute('navegacao', ['controller' => 'usuario-usuario', 'action' => 'alterar-senha']);
            return FALSE;
        }

        //Verifica se a senha atual é igual a senha antiga
        if (strcasecmp(md5($this->getRequest()->getPost()->get('pw_senha')), md5($this->getRequest()->getPost()->get('pw_nova_senha'))) == 0) {

            $this->addErrorMessage('Nova senha igual a senha atual.');
            $this->redirect()->toRoute('navegacao', ['controller' => 'usuario-usuario', 'action' => 'alterar-senha']);
            return FALSE;
        }

        //Seta a nova senha
        $loginEntity->setPwSenha(md5(trim($this->getRequest()->getPost()->get('pw_nova_senha'))));
        $loginEntity->salvar();

        $this->addSuccessMessage('Senha alterada com sucesso.');
        $this->redirect()->toRoute('navegacao', ['controller' => 'usuario-usuario', 'action' => 'atualizar-dados']);
        return FALSE;
    }

}
