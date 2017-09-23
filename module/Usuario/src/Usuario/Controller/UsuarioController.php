<?php

namespace Usuario\Controller;

use Estrutura\Controller\AbstractCrudController;
use Estrutura\Helpers\Cript;
use Estrutura\Helpers\Data;
use Zend\Filter\File\Encrypt;
use Zend\View\Model\ViewModel;
use Estrutura\Service\HtmlHelper;


class UsuarioController extends AbstractCrudController
{

    /**
     * @var \Usuario\Service\Usuario
     */
    protected $service;

    /**
     * @var \Usuario\Form\Usuario
     */

    protected $form;
    protected $camposPendencia = [
        'nm_funcao',
    ];

    public function __construct()
    {
        parent::init();
    }

    public function indexAction()
    {
        return parent::index($this->service, $this->form);
    }

    public function indexPaginationAction()
    {
        //http://igorrocha.com.br/tutorial-zf2-parte-9-paginacao-busca-e-listagem/4/

        $filter = $this->getFilterPage();

        $camposFilter = [
            '0' => NULL,
            '1' => [
                'filter' => "perfil.nm_perfil LIKE ?",
            ],
            '2' => [
                'filter' => "usuario.nm_usuario LIKE ?",
            ],
            '3' =>[
                'filter' => "usuario.nm_funcao LIKE ?",
            ],
            '4' => NULL,
        ];


        $paginator = $this->service->getUsuarioPaginator($filter, $camposFilter);

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

    public function desativarAction()
    {
        try {
            $controller = $this->params('controller');
            $id = $this->params()->fromRoute('id');  // From RouteMatch
            $service = $this->service;

            if (isset($id) && $id) {
                $post['id'] = Cript::dec($id);
                $post['id_situacao_usuario'] = $this->getConfigList()['situacao_usuario_inativo'];
            }

            $service->exchangeArray($post);
            $this->addSuccessMessage('Registro desativado com sucesso!');
            $this->redirect()->toRoute('navegacao', array('controller' => $controller, 'action' => 'index'));
            $service->salvar();
            return true;

        } catch (\Exception $e) {

            $this->setPost($post);
            $this->addErrorMessage($e->getMessage());
            $this->redirect()->toRoute('navegacao', array('controller' => $controller, 'action' => 'cadastro'));
            return false;
        }
    }

    /**
     *
     * @return boolean
     */
    public function gravarAction()
    {

        $form = new \Usuario\Form\UsuarioForm();

        /* @var $emailService \Email\Service\EmailService */
        $emailService = $this->getServiceLocator()->get('\Email\Service\EmailService');
        $emailService->setEmEmail(trim($this->getRequest()->getPost()->get('em_email')));

        #Alysson - Verifica se já existe este emaill cadastrado para um usuário
        if ($emailService->filtrarObjeto()->count()) {

            $this->addErrorMessage('Email já cadastrado. Faça seu login.');
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

        #Alysson - Realiza tratamento nos dados do telefone para Atribuir ao POST os parametros abaixo.
        $this->getRequest()->getPost()->set('nr_ddd_telefone', \Estrutura\Helpers\Telefone::getDDD($this->getRequest()->getPost()->get('nr_telefone')));
        $this->getRequest()->getPost()->set('nr_telefone', \Estrutura\Helpers\Telefone::getTelefone($this->getRequest()->getPost()->get('nr_telefone')));
        $this->getRequest()->getPost()->set('id_tipo_telefone', $this->getConfigList()['tipo_telefone_residencial']);
        $this->getRequest()->getPost()->set('id_situacao', $this->getConfigList()['situacao_ativo']);

        #Alysson - Realiza a Gravação do telefone e retorna o ID inserido para a variavel $resultTelefone
        $resultTelefone = parent::gravar(
            $this->getServiceLocator()->get('\Telefone\Service\TelefoneService'), new \Telefone\Form\TelefoneForm()
        );

        #Se o Telefone foi Inserido com sucesso
        if ($resultTelefone) {
            #Alysson - Realiza a Gravação do email  e retorna o ID inserido para a variavel $resultEmail
            $resultEmail = parent::gravar(
                $this->getServiceLocator()->get('\Email\Service\EmailService'), new \Email\Form\EmailForm()
            );

            #Se o Email foi Inserido com sucesso
            if ($resultEmail) {

                $this->getRequest()->getPost()->set('nm_usuario', $this->getRequest()->getPost()->get('nm_usuario'));
                $this->getRequest()->getPost()->set('id_sexo', $this->getRequest()->getPost()->get('id_sexo'));
                $this->getRequest()->getPost()->set('id_perfil', $this->getRequest()->getPost()->get('id_perfil'));
                $this->getRequest()->getPost()->set('id_situacao_usuario', $this->getConfigList()['situacao_usuario_ativo']);
                $this->getRequest()->getPost()->set('id_email', $resultEmail); #id_email inserido anteriormente
                $this->getRequest()->getPost()->set('id_telefone', $resultTelefone); #id_telefone inserido anteriormente

                $resultUsuario = parent::gravar(
                    $this->getServiceLocator()->get('\Usuario\Service\UsuarioService'), new \Usuario\Form\UsuarioForm()
                );

                if ($resultUsuario) {

                    $this->getRequest()->getPost()->set('id_usuario', $resultUsuario);
                    //Verifica se é dia 29, 30, 31
                    $this->getRequest()->getPost()->set('dt_registro', (date('d') >= 29 ? date('Y-m-' . 28 . ' H:m:s') : date('Y-m-d H:m:s')));
                    $this->getRequest()->getPost()->set('id_perfil', $this->getRequest()->getPost()->get('id_perfil'));
                    $this->getRequest()->getPost()->set('pw_senha', md5($this->getRequest()->getPost()->get('pw_senha')));
                    $this->getRequest()->getPost()->set('id_situacao', $this->getConfigList()['situacao_inativo']);

                    $resultLogin = parent::gravar(
                        $this->getServiceLocator()->get('\Login\Service\LoginService'), new \Login\Form\LoginForm()
                    );

                    #Se cadastro realizado com sucesso, dispara um email para o usuario
                    if ($resultLogin) {

                        #$contaEmail = 'no-reply';#

//                        $message = new \Zend\Mail\Message();
//                        $message->addFrom($contaEmail . '@hepta.com.br', 'Hepta Tecnologia')
//                            ->addTo(trim($this->getRequest()->getPost()->get('em_email'))) #Envia para o Email que cadastrou
//                            ->addBcc('alysson.vicuna@gmail.com')
//                            ->setSubject('Confirmação de cadastro');
//
//                        $applicationService = new \Application\Service\ApplicationService();
//                        $transport = $applicationService->getSmtpTranport($contaEmail);
//
//                        $htmlMessage = $applicationService->tratarModelo(
//                            [
//                                'BASE_URL' => BASE_URL,
//                                'nomeUsuario' => trim($this->getRequest()->getPost()->get('nm_usuario')),
//                                'txIdentificacao' => base64_encode(\Estrutura\Helpers\Bcrypt::hash($resultLogin)),
//                                'email' => trim($this->getRequest()->getPost()->get('em_email')),
//                            ], $applicationService->getModelo('cadastro'));
//
//                        $html = new \Zend\Mime\Part($htmlMessage);
//                        $html->type = "text/html";
//
//                        $body = new \Zend\Mime\Message();
//                        $body->addPart($html);
//
//                        $message->setBody($body);
//                        $transport->send($message);

                        $this->addSuccessMessage('Cadastro realizado com sucesso!');
                        #$this->addSuccessMessage('Parabéns! Cadastro realizado com sucesso. Para confirmar seu cadastro, leia as instruções que enviamos para você por e-mail.');
//                        $this->getServiceLocator()->get('Auth\Table\MyAuth')->forgetMe();
//                        $this->getServiceLocator()->get('AuthService')->clearIdentity();

                    }
                }
            }
        }

        #$this->redirect()->toRoute('navegacao', array('controller' => 'auth', 'action' => 'login'));
        $this->redirect()->toRoute('navegacao', array('controller' => 'usuario-usuario', 'action' => 'index'));
    }

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

    public function atualizarDadosAction()
    {
        $id = $this->params()->fromRoute('id');  // From RouteMatch
        $id = Cript::dec($id);  // From RouteMatch);

        $auth = $this->getServiceLocator()->get('AuthService')->getStorage()->read();
        $usuarioService = new \Usuario\Service\UsuarioService();

        if($auth->id_perfil == TXT_CONST_PERFIL_ADMINISTRADOR){
            $usuario = $usuarioService->getUsuario($id);
        } else {
            $usuario = $usuarioService->getUsuario($auth->id_usuario);
        }

        $usuario['id'] = $usuario['id_usuario'];
        $usuario['nr_telefone'] = $usuario['nr_ddd_telefone'] . $usuario['nr_telefone'];

        $form = new \Usuario\Form\AtualizaUsuarioForm();
        $form->setData($usuario);

        $post = $this->getPost();

        if (!empty($post)) {

            $form->setData($post);
        }

        return new ViewModel([
            'configList' => $this->getConfigList(),
            'form' => $form,
            'controller' => $this->params('controller'),
            'usuario' => $usuario,
            'auth' => $auth,
        ]);
    }

    public function excluirAction()
    {
        return parent::excluir($this->service, $this->form);
    }

    /**
     * Grava na base de dados as alterações realizadas na tela de cadastro
     *
     * @return bool
     * @throws \Exception
     */
    public function gravarAtualizacaoAction()
    {
        $controller = $this->params('controller');
        $request = $this->getRequest();

        if (!$request->isPost()) {
            throw new \Exception('Dados Inválidos');
        }

        $post = \Estrutura\Helpers\Utilities::arrayMapArray('trim', $request->getPost()->toArray());

        try {
            $auth = $this->getServiceLocator()->get('AuthService')->getStorage()->read();
            $post['id'] = Cript::dec($post['id']);
            $id = $post['id'];
            $usuarioService = new \Usuario\Service\UsuarioService();
            if($auth->id_perfil == TXT_CONST_PERFIL_ADMINISTRADOR){
                $usuarioEntity = $usuarioService->buscar($id);
            } else {
                $usuarioEntity = $usuarioService->buscar($auth->id_usuario);
            }

            $form = new \Usuario\Form\AtualizaUsuarioForm();
            $form->setData($post);

            if (!$form->isValid()) {
                $this->addValidateMessages($form);
                $this->setPost($post);
                $this->redirect()->toRoute('navegacao', array('controller' => $controller, 'action' => 'atualizar-dados', 'id' => Cript::dec($id)));
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
                $this->redirect()->toRoute('navegacao', array('controller' => $controller, 'action' => 'atualizar-dados', 'id' => Cript::dec($id)));
                return FALSE;
            }
            $telefoneService = $this->getServiceLocator()->get('\Telefone\Service\TelefoneService');
            $telefoneService->exchangeArray($formTelefone->getData());
            $telefoneService->salvar();

            //Atualiza dados usuario
            $usuarioEntity->setNmUsuario($this->getRequest()->getPost()->get('nm_usuario'));
            $usuarioEntity->setNmFuncao($this->getRequest()->getPost()->get('nm_funcao'));
            $usuarioEntity->setIdSexo($this->getRequest()->getPost()->get('id_sexo'));
            $usuarioEntity->setIdSituacaoUsuario($this->getRequest()->getPost()->get('id_situacao_usuario'));
            $usuarioEntity->salvar();

            $this->flashmessenger()->addSuccessMessage('Dados atualizado com sucesso.');
            $this->redirect()->toRoute('navegacao', array('controller' => 'usuario-usuario', 'action' => 'index'));
            return TRUE;
        } catch (\Exception $e) {
            $this->setPost($post);
            $this->addErrorMessage($e->getMessage());
            $this->redirect()->toRoute('navegacao', array('controller' => $controller, 'action' => 'atualizar-dados', 'id' => Cript::dec($id)));
            return FALSE;
        }
    }

    /**
     * Exibe a tela para alteração de senha
     *
     * @return ViewModel
     */
    public function alterarSenhaAction()
    {
        $auth = $this->getServiceLocator()->get('AuthService')->getStorage()->read();
        $id = $this->params()->fromRoute('id');  // From RouteMatch
        $id = Cript::dec($id);  // From RouteMatch);

        $usuarioService = new \Usuario\Service\UsuarioService();
        if($auth->id_perfil == TXT_CONST_PERFIL_ADMINISTRADOR){
            $usuarioEntity = $usuarioService->buscar($id);
        } else {
            $usuarioEntity = $usuarioService->buscar($auth->id_usuario);
        }

        return new ViewModel([
            'configList' => $this->getConfigList(),
            'form' => new \Auth\Form\RedefinirSenhaForm(),
            'controller' => $this->params('controller'),
            'usuarioEntity' => $usuarioEntity,
            'auth' => $auth,
            'id_usuario' => $id, //Passa o Id_usuario para aview

        ]);
    }

    /**
     * Método que realiza a gravação da alteração de senha na base de dados
     *
     * @return bool
     */
    public function salvarRedefinicaoSenhaAction()
    {

        $auth = $this->getServiceLocator()->get('AuthService')->getStorage()->read();
        $request = $this->getRequest();

        if (!$request->isPost()) {
            throw new \Exception('Dados Inválidos');
        }

        $post= \Estrutura\Helpers\Utilities::arrayMapArray('trim', $request->getPost()->toArray());
        $id_usuario = Cript::dec($post['id']);
        $post['id'] = $id_usuario; //Recebe o ID ja Descriptografado.

        $loginService = new \Login\Service\LoginService();
        $loginService->setIdUsuario($id_usuario);
        $loginEntity = $loginService->filtrarObjeto()->current();

        if (!$loginEntity) {
            $this->addErrorMessage('Usuario inválido.');
            $this->redirect()->toRoute('navegacao', ['controller' => 'usuario-usuario', 'action' => 'alterar-senha', 'id'=>Cript::enc($id_usuario)]);
            return FALSE;
        }

        //Verifica tamanho da senha
        if (strlen(trim($this->getRequest()->getPost()->get('pw_nova_senha'))) < 8) {

            $this->addErrorMessage('Senha deve ter no mínimo 8 caracteres.');
            $this->redirect()->toRoute('navegacao', ['controller' => 'usuario-usuario', 'action' => 'alterar-senha', 'id'=>Cript::enc($id_usuario)]);
            return FALSE;
        }

        #so faz esta validacao se for o usuario diferente do Administrador
        if($auth->id_perfil != TXT_CONST_PERFIL_ADMINISTRADOR) {
            //Verifica se a senha atual é válida
            if (strcasecmp(md5($this->getRequest()->getPost()->get('pw_senha')), $loginEntity->getPwSenha()) != 0) {
                $this->addErrorMessage('Senha atual inválida.');
                $this->redirect()->toRoute('navegacao', ['controller' => 'usuario-usuario', 'action' => 'alterar-senha', 'id' => Cript::enc($id_usuario)]);
                return FALSE;
            }
        }
        //Verifica se as novas senhas são iguais
        if (strcasecmp($this->getRequest()->getPost()->get('pw_nova_senha_confirm'), $this->getRequest()->getPost()->get('pw_nova_senha')) != 0) {

            $this->addErrorMessage('Senhas não correspondem.');
            $this->redirect()->toRoute('navegacao', ['controller' => 'usuario-usuario', 'action' => 'alterar-senha', 'id'=>Cript::enc($id_usuario)]);
            return FALSE;
        }

        //Verifica se a senha atual é igual a senha antiga
        if (strcasecmp(md5($this->getRequest()->getPost()->get('pw_senha')), md5($this->getRequest()->getPost()->get('pw_nova_senha'))) == 0) {

            $this->addErrorMessage('Nova senha igual a senha atual.');
            $this->redirect()->toRoute('navegacao', ['controller' => 'usuario-usuario', 'action' => 'alterar-senha', 'id'=>Cript::enc($id_usuario)]);
            return FALSE;
        }

        //Seta a nova senha
        $loginEntity->setPwSenha(md5(trim($this->getRequest()->getPost()->get('pw_nova_senha'))));
        $loginEntity->salvar();

        $this->addSuccessMessage('Senha alterada com sucesso.');
        $this->redirect()->toRoute('navegacao', ['controller' => 'usuario-usuario', 'action' => 'atualizar-dados', 'id'=>Cript::enc($id_usuario)]);
        return FALSE;
    }

    /**
     * Exibe a tela para alteração de e-mail
     *
     * @return ViewModel
     */
    public function alterarEmailAction(){

        $auth = $this->getServiceLocator()->get('AuthService')->getStorage()->read();
        $id = $this->params()->fromRoute('id');  // From RouteMatch
        $id = Cript::dec($id);  // From RouteMatch);

        $usuarioService = new \Usuario\Service\UsuarioService();
        if($auth->id_perfil == TXT_CONST_PERFIL_ADMINISTRADOR){
            $usuarioEntity = $usuarioService->buscar($id);
        } else {
            $usuarioEntity = $usuarioService->buscar($auth->id_usuario);
        }

        return new ViewModel([
            'configList' => $this->getConfigList(),
            'form' => new \Auth\Form\RedefinirEmailForm(),
            'controller' => $this->params('controller'),
            'usuarioEntity' => $usuarioEntity,
            'auth' => $auth,
            'id_usuario' => $id, //Passa o Id_usuario para a view

        ]);
    }

    /**
     * Método que realiza a gravação da alteração do e-mail na base de dados
     *
     * @return bool
     */

    public function salvarRedefinicaoEmailAction(){

        $auth = $this->getServiceLocator()->get('AuthService')->getStorage()->read();
        $request = $this->getRequest();

        if (!$request->isPost()) {
            throw new \Exception('Dados Inválidos');
        }


        $post= \Estrutura\Helpers\Utilities::arrayMapArray('trim', $request->getPost()->toArray());

        $id_usuario = Cript::dec($post['id']);
        $post['id'] = $id_usuario; //Recebe o ID já Descriptografado.

        $loginService = new \Login\Service\LoginService();
        $loginService->setIdUsuario($id_usuario);
        $loginEntity = $loginService->filtrarObjeto()->current();



        if (!$loginEntity) {
            $this->addErrorMessage('Usuário inválido.');
            $this->redirect()->toRoute('navegacao', ['controller' => 'usuario-usuario', 'action' => 'alterar-email', 'id'=>Cript::enc($id_usuario)]);
            return FALSE;
        }



        #so faz esta validacao se for o usuario diferente do Administrador
        if($auth->id_perfil != TXT_CONST_PERFIL_ADMINISTRADOR) {
            //Verifica se a e-mail atual é válida
            if (strcasecmp($this->getRequest()->getPost()->get('em_email'), $loginEntity->getIdEmail()) != 0) {
                $this->addErrorMessage('E-mail atual inválido.');
                $this->redirect()->toRoute('navegacao', ['controller' => 'usuario-usuario', 'action' => 'alterar-email',
                    'id' => Cript::enc($id_usuario)]);
                return FALSE;
            }
        }


        //Verifica se os novos e-mails são iguais
        if (strcasecmp($this->getRequest()->getPost()->get('em_novo_email_confirm'), $this->getRequest()->getPost()
                ->get('em_novo_email')) != 0) {

            $this->addErrorMessage('E-mails não correspondem.');
            $this->redirect()->toRoute('navegacao', ['controller' => 'usuario-usuario', 'action' => 'alterar-email',
                'id'=>Cript::enc($id_usuario)]);
            return FALSE;
        }

        //Verifica se o e-mail atual é igual ao e-mail antigo
        if (strcasecmp($this->getRequest()->getPost()->get('em_email'), $this->getRequest()->getPost()->get('em_novo_email')) == 0) {

            $this->addErrorMessage('Novo e-mail igual o e-mail atual.');
            $this->redirect()->toRoute('navegacao', ['controller' => 'usuario-usuario', 'action' => 'alterar-email',
                'id'=>Cript::enc($id_usuario)]);
            return FALSE;
        }

        #Recupera os dados do usuario logado e captura o id_email dele
        $usuarioService = new \Usuario\Service\UsuarioService();
        $usuarioService->setId($id_usuario); #Id do email a ser alterado
        $arrUsuarioEntity = $usuarioService->filtrarObjeto()->current()->toArray();

        #Atualiza o email com o id recuperado nas linhas anteriores
        $emailService = new \Email\Service\EmailService();
        $emailService->setId($arrUsuarioEntity['id_email']); #Id do email a ser alterado
        $emailService->setIdSituacao(true); #Id do email a ser alterado
        $emailService->setEmEmail($this->getRequest()->getPost()->get('em_novo_email')); #Id do email a ser alterado
        $emailService->salvar();
        ##################################################################


        #xd('35');

        $this->addSuccessMessage('E-mail alterado com sucesso.');
        $this->redirect()->toRoute('navegacao', ['controller' => 'usuario-usuario', 'action' => 'atualizar-dados',
            'id'=>Cript::enc($id_usuario)]);
        return FALSE;
    }


}
