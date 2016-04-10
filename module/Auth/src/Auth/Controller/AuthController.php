<?php

namespace Auth\Controller;

use Estrutura\Controller\AbstractCrudController;
use Zend\View\Model\ViewModel;

class AuthController extends AbstractCrudController {

    /**
     * @var \Auth\Service\Auth
     */
    protected $service;

    /**
     * @var \Auth\Form\Auth
     */
    protected $form;
    protected $storage;
    protected $authService;

    public function __construct()
    {
        parent::init();
    }

    public function indexAction()
    {
        return parent::index($this->service, $this->form);
    }

    public function getForm()
    {
        if (!$this->form) {

            $this->setFormObj();
        }

        return $this->form;
    }

    /**
     * 
     * @return \Zend\Authentication\AuthenticationService
     */
    public function getAuthService()
    {
        if (!$this->authService) {

            $this->authService = $this->getServiceLocator()->get('AuthService');
        }

        return $this->authService;
    }

    public function getSessionStorage()
    {
        if (!$this->storage) {

            $this->storage = $this->getServiceLocator()->get('Auth\Table\MyAuth');
        }

        return $this->storage;
    }

    /**
     * Mostra a tela de login
     * @return type
     */
    public function loginAction()
    {
        if ($this->getAuthService()->hasIdentity()) {

            //return $this->redirect()->toRoute('navegacao', array('controller' => 'usuario-usuario', 'action' => 'index'));
            #Alysson - Definindo pra qual página deverá ser redirecionado após o Login
            return $this->redirect()->toRoute('navegacao', array('controller' => 'principal-principal', 'action' => 'index'));
        }

        $form = $this->getForm();
        return array(
            'form' => $form,
            'messages' => $this->flashmessenger()->getMessages()
        );
    }

    /**
     * Autentica o usuário
     * 
     * @return type
     */
    public function authenticateAction()
    {
        try {

            $form = $this->getForm();

            $request = $this->getRequest();

            if (!$request->isPost()) {

                throw new \Exception('Dados Inválidos');
            }

            $form->setData($request->getPost());

            if (!$form->isValid()) {

                $this->addValidateMessages($form);
                $this->setPost($request);
                return $this->redirect()->toRoute('login');
            }

            //check authentication...            
            $this->getAuthService()->getAdapter()
                    ->setIdentity($request->getPost('email'))
                    ->setCredential($request->getPost('senha'));

            $result = $this->getAuthService()->authenticate();

            $translate = $this->getServiceLocator()->get('viewhelpermanager')->get('translate');

            foreach ($result->getMessages() as $message) {

                //save message temporary into flashmessenger                
                if ($result->getCode() == 1) {

//                    $this->flashmessenger()->addSuccessMessage($translate($message, 'Auth'));
                } else {

                    $this->flashmessenger()->addErrorMessage($translate($message, 'Auth'));
                }
            }

            if ($result->isValid()) {

                $resultRow = $this->getAuthService()->getAdapter()->getResultRowObject(null, "pw_senha");
                $this->getAuthService()->getStorage()->write($resultRow);
            }

            return $this->redirect()->toRoute('login');
        } catch (\Exception $e) {

            $this->setPost($this->getPost());
            $this->addErrorMessage($e->getMessage());
            return $this->redirect()->toRoute('login');
        }
    }

    /**
     * Realiza o Logoff
     * 
     * @return type
     */
    public function logoffAction()
    {
        $this->getSessionStorage()->forgetMe();
        $this->getAuthService()->clearIdentity();

        $this->flashmessenger()->addMessage("Você foi desconectado");
        return $this->redirect()->toRoute('login');
    }

    /**
     * 
     * @return type
     */
    public function captchaAction()
    {

        $response = $this->getResponse();
        $response->getHeaders()->addHeaderLine('Content-Type', "image/png");

        $id = $this->params('id', false);

        if ($id) {

            $image = BASE_PATCH . '/data/captcha/' . $id;

            if (file_exists($image) !== false) {
                $imagegetcontent = file_get_contents($image);

                $response->setStatusCode(200);
                $response->setContent($imagegetcontent);

                if (file_exists($image) == true) {
                    unlink($image);
                }
            }
        }

        return $response;
    }

    /**
     * 
     */
    public function esqueciSenhaAction()
    {

        return new ViewModel([
            'form' => new \Auth\Form\EsqueciSenhaForm(),
            'controller' => $this->params('controller'),
        ]);
    }

    /**
     * 
     * @param type $param
     * @return boolean
     */
    public function solicitarSenhaAction()
    {

        $form = new \Auth\Form\EsqueciSenhaForm();

        $elementCaptch = $form->getElements()['captcha'];
        foreach ($elementCaptch->getInputSpecification()['validators'] as $validator) {

            if (!$validator->isValid($this->getRequest()->getPost()->get('captcha'))) {

                $this->addErrorMessage('Captcha inválido.');
                $this->redirect()->toRoute('navegacao', ['controller' => 'auth', 'action' => 'esqueci-senha']);
                return FALSE;
            }
        }

        /* @var $emailService \Email\Service\EmailService */
        $emailService = $this->getServiceLocator()->get('\Email\Service\EmailService');
        $emailService->setEmEmail($this->getRequest()->getPost()->get('email'));
        $emailList = $emailService->filtrarObjeto();

        if (!$emailList->count()) {

            $this->addErrorMessage('E-mail não consta cadastrado.');
            $this->redirect()->toRoute('navegacao', ['controller' => 'auth', 'action' => 'esqueci-senha']);
            return FALSE;
        }

        $emailEntity = $emailList->current();

        $usuarioService = new \Usuario\Service\UsuarioService();
        $usuarioService->setIdEmail($emailEntity->getId());
        $usuarioEntity = $usuarioService->filtrarObjeto()->current();

        $esqueciSenhaService = new \EsqueciSenha\Service\EsqueciSenhaService();
        $esqueciSenhaService->setIdSituacao($this->getConfigList()['situacao_ativo']);
        $esqueciSenhaService->setIdUsuario($usuarioEntity->getId());
        $listEsqueciSenha = $esqueciSenhaService->filtrarObjeto();

        if ($listEsqueciSenha->count()) {

            foreach ($listEsqueciSenha as $esqueciSenhaEntityAux) {

                $dateSolicitacao = new \DateTime($esqueciSenhaEntityAux->getDtSolicitacao());

                $dataAtual = new \Datetime();
                $dataAtual->modify('-1 hours');

                if ($dateSolicitacao < $dataAtual) {

                    $esqueciSenhaEntityAux->setIdSituacao($this->getConfigList()['situacao_inativo']);
                    $esqueciSenhaEntityAux->salvar();
                } else {

                    $this->addErrorMessage('Existe uma solicitação de redefinição de senha vigente. Verifique seu e-mail');
                    $this->redirect()->toRoute('navegacao', ['controller' => 'auth', 'action' => 'login']);
                    return FALSE;
                }
            }
        }

        $txIdentificacao = md5(uniqid(mt_rand(), true));

        $esqueciSenhaService = new \EsqueciSenha\Service\EsqueciSenhaService();
        $esqueciSenhaService->exchangeArray([
            'id' => NULL,
            'id_usuario' => $usuarioEntity->getId(),
            'tx_identificacao' => $txIdentificacao,
            'id_situacao' => $this->getConfigList()['situacao_ativo'],
            'dt_solicitacao' => date('Y-m-d H:i:s'),
        ]);
        if ($esqueciSenhaService->salvar()) {

            $contaEmail = 'no-reply';

            $message = new \Zend\Mail\Message();
            $message->addFrom($contaEmail . '@mcnetwork.com.br', 'MC Network')
//                    @TODO
//                        ->addTo($emailEntity->getEmEmail())
                    ->addTo('ronaldo.r.melo@gmail.com')
                    ->addBcc('mcnetwork@mcnetwork.com.br')
                    ->setSubject('Redefinição de senha');

            $applicationService = new \Application\Service\ApplicationService();
            $transport = $applicationService->getSmtpTranport($contaEmail);

            $htmlMessage = $applicationService->tratarModelo(
                    [
                'BASE_URL' => BASE_URL,
                'nomeUsuario' => $usuarioEntity->getNmUsuario(),
                'txIdentificacao' => base64_encode(\Estrutura\Helpers\Bcrypt::hash($txIdentificacao)),
                'email' => $emailEntity->getEmEmail(),
                    ], $applicationService->getModelo('solicitar-senha'));

            $html = new \Zend\Mime\Part($htmlMessage);
            $html->type = "text/html";

            $body = new \Zend\Mime\Message();
            $body->addPart($html);

            $message->setBody($body);
            $transport->send($message);

            $this->addSuccessMessage('Redefinição de senha enviado para o e-mail ' . $emailEntity->getEmEmail());
            $this->redirect()->toRoute('navegacao', ['controller' => 'auth', 'action' => 'login']);
            return TRUE;
        } else {
            $this->addErrorMessage('Não foi possível redefinir a senha. Tente novamente mais tarde.');
            $this->redirect()->toRoute('navegacao', ['controller' => 'auth', 'action' => 'esqueci-senha']);
            return FALSE;
        }
    }

    /**
     * 
     * @return boolean|ViewModel
     */
    public function redefinirSenhaAction()
    {

        $id = base64_decode($this->params('id'));

        if (!$id) {

            $this->addErrorMessage('Token não informado. Solicite outra redefinição de senha');
            $this->redirect()->toRoute('navegacao', ['controller' => 'auth', 'action' => 'login']);
            return FALSE;
        }

        $esqueciSenhaService = new \EsqueciSenha\Service\EsqueciSenhaService();
        $esqueciSenhaService->setIdSituacao($this->getConfigList()['situacao_ativo']);
        $listEsqueciSenha = $esqueciSenhaService->filtrarObjeto();

        if (!$listEsqueciSenha->count()) {

            $this->addErrorMessage('Token inválido. Solicite outra redefinição de senha');
            $this->redirect()->toRoute('navegacao', ['controller' => 'auth', 'action' => 'login']);
            return FALSE;
        }

        $esqueciSenhaEntity = NULL;
        foreach ($listEsqueciSenha as $esqueciSenhaEntityAux) {

            if (crypt($esqueciSenhaEntityAux->getTxIdentificacao(), $id) === $id) {

                $esqueciSenhaEntity = $esqueciSenhaEntityAux;
            } else {

                $dateSolicitacao = new \DateTime($esqueciSenhaEntityAux->getDtSolicitacao());

                $dataAtual = new \Datetime();
                $dataAtual->modify('-1 hours');

                if ($dateSolicitacao < $dataAtual) {

                    $esqueciSenhaEntityAux->setIdSituacao($this->getConfigList()['situacao_inativo']);
                    $esqueciSenhaEntityAux->salvar();
                }
            }
        }

        if (!$esqueciSenhaEntity) {

            $this->addErrorMessage('Token inválido. Solicite outra redefinição de senha');
            $this->redirect()->toRoute('navegacao', ['controller' => 'auth', 'action' => 'login']);
            return FALSE;
        }

        $dateSolicitacao = new \DateTime($esqueciSenhaEntity->getDtSolicitacao());

        $dataAtual = new \Datetime();
        $dataAtual->modify('-1 hours');

        if ($dateSolicitacao < $dataAtual) {

            $esqueciSenhaEntity->setIdSituacao($this->getConfigList()['situacao_inativo']);
            $esqueciSenhaEntity->salvar();

            $this->addErrorMessage('Token expirado. Solicite outra redefinição de senha');
            $this->redirect()->toRoute('navegacao', ['controller' => 'auth', 'action' => 'login']);
            return FALSE;
        }

        $usuarioService = new \Usuario\Service\UsuarioService();
        $usuarioEntity = $usuarioService->buscar($esqueciSenhaEntity->getIdUsuario());

        return new ViewModel([
            'controller' => $this->params('controller'),
            'form' => new \Auth\Form\RedefinirSenhaForm(),
            'usuarioEntity' => $usuarioEntity,
            'esqueciSenhaEntity' => $esqueciSenhaEntity,
        ]);
    }

    /**
     * 
     * @return boolean
     */
    public function salvarRedefinicaoSenhaAction()
    {

        $form = new \Auth\Form\RedefinirSenhaForm();
        $txIdentificacao = base64_decode($this->getRequest()->getPost()->get('tx_identificacao'));

        if (!$txIdentificacao) {

            $this->addErrorMessage('Token não informado. Solicite outra redefinição de senha.');
            $this->redirect()->toRoute('navegacao', ['controller' => 'auth', 'action' => 'login']);
            return FALSE;
        }

        $elementCaptch = $form->getElements()['captcha'];
        foreach ($elementCaptch->getInputSpecification()['validators'] as $validator) {

            if (!$validator->isValid($this->getRequest()->getPost()->get('captcha'))) {

                $this->addErrorMessage('Captcha inválido.');
                $this->redirect()->toRoute('navegacao', ['controller' => 'auth', 'action' => 'redefinir-senha', 'id' => base64_encode($txIdentificacao)]);
                return FALSE;
            }
        }

        $id_usuario = \Estrutura\Helpers\Cript::dec($this->getRequest()->getPost()->get('id_usuario'));

        $esqueciSenhaService = new \EsqueciSenha\Service\EsqueciSenhaService();
        $esqueciSenhaService->setIdUsuario($id_usuario);
        $esqueciSenhaService->setIdSituacao($this->getConfigList()['situacao_ativo']);
        $esqueciSenhaEntity = $esqueciSenhaService->filtrarObjeto()->current();

        if (!$esqueciSenhaEntity) {

            $this->addErrorMessage('Token inválido. Solicite outra redefinição de senha.');
            $this->redirect()->toRoute('navegacao', ['controller' => 'auth', 'action' => 'login']);
            return FALSE;
        }

        if (crypt($esqueciSenhaEntity->getTxIdentificacao(), $txIdentificacao) != $txIdentificacao) {

            $this->addErrorMessage('Token inválido. Solicite outra redefinição de senha.');
            $this->redirect()->toRoute('navegacao', ['controller' => 'auth', 'action' => 'login']);
            return FALSE;
        }

        $dateSolicitacao = new \DateTime($esqueciSenhaEntity->getDtSolicitacao());

        $dataAtual = new \Datetime();
        $dataAtual->modify('-2 hours');

        if ($dateSolicitacao < $dataAtual) {

            $esqueciSenhaEntity->setIdSituacao($this->getConfigList()['situacao_inativo']);
            $esqueciSenhaEntity->salvar();

            $this->addErrorMessage('Token expirado. Solicite outra redefinição de senha.');
            $this->redirect()->toRoute('navegacao', ['controller' => 'auth', 'action' => 'login']);
            return FALSE;
        }

        $loginService = new \Login\Service\LoginService();
        $loginService->setIdUsuario($id_usuario);
        $loginEntity = $loginService->filtrarObjeto()->current();

        if (!$loginEntity) {

            $this->addErrorMessage('Token inválido. Solicite outra redefinição de senha.');
            $this->redirect()->toRoute('navegacao', ['controller' => 'auth', 'action' => 'login']);
            return FALSE;
        }

        //Verifica tamanho da senha
        if (strlen(trim($this->getRequest()->getPost()->get('pw_nova_senha'))) < 8) {

            $this->addErrorMessage('Senha deve ter no mínimo 8 caracteres.');
            $this->redirect()->toRoute('navegacao', ['controller' => 'auth', 'action' => 'redefinir-senha', 'id' => base64_encode($txIdentificacao)]);
            return FALSE;
        }

        //Verifica se as novas senhas são iguais
        if (strcasecmp($this->getRequest()->getPost()->get('pw_nova_senha_confirm'), $this->getRequest()->getPost()->get('pw_nova_senha')) != 0) {

            $this->addErrorMessage('Senhas não correspondem.');
            $this->redirect()->toRoute('navegacao', ['controller' => 'auth', 'action' => 'redefinir-senha', 'id' => base64_encode($txIdentificacao)]);
            return FALSE;
        }

        //Verifica se a senha atual é igual a senha antiga
        if (strcasecmp($loginEntity->getPwSenha(), md5($this->getRequest()->getPost()->get('pw_nova_senha'))) == 0) {

            $this->addErrorMessage('Nova senha igual a senha atual.');
            $this->redirect()->toRoute('navegacao', ['controller' => 'auth', 'action' => 'redefinir-senha', 'id' => base64_encode($txIdentificacao)]);
            return FALSE;
        }

        //Seta a nova senha
        $loginEntity->setPwSenha(md5(trim($this->getRequest()->getPost()->get('pw_nova_senha'))));
        $loginEntity->salvar();

        //Desativa o esqueci senha atual
        $esqueciSenhaEntity->setIdSituacao($this->getConfigList()['situacao_inativo']);
        $esqueciSenhaEntity->salvar();

        /* @var $emailService \Email\Service\EmailService */
        $emailService = $this->getServiceLocator()->get('\Email\Service\EmailService');
        $emailEntity = $emailService->buscar($loginEntity->getIdEmail());

        $usuarioService = new \Usuario\Service\UsuarioService();
        $usuarioEntity = $usuarioService->buscar($id_usuario);

        $txIdentificacao = md5(uniqid(mt_rand(), true));

        $esqueciSenhaService = new \EsqueciSenha\Service\EsqueciSenhaService();
        $esqueciSenhaService->exchangeArray([
            'id' => NULL,
            'id_usuario' => $usuarioEntity->getId(),
            'tx_identificacao' => $txIdentificacao,
            'id_situacao' => $this->getConfigList()['situacao_ativo'],
            'dt_solicitacao' => date('Y-m-d H:i:s'),
        ]);
        $esqueciSenhaService->salvar();

        $contaEmail = 'no-reply';

        $message = new \Zend\Mail\Message();
        $message->addFrom($contaEmail . '@mcnetwork.com.br', 'MC Network')
//                    @TODO
//                        ->addTo($emailEntity->getEmEmail())
                ->addTo('ronaldo.r.melo@gmail.com')
                ->addBcc('mcnetwork@mcnetwork.com.br')
                ->setSubject('A senha da conta do MC Network foi redefinida');

        $applicationService = new \Application\Service\ApplicationService();
        $transport = $applicationService->getSmtpTranport($contaEmail);

        $htmlMessage = $applicationService->tratarModelo(
                [
            'BASE_URL' => BASE_URL,
            'nomeUsuario' => $usuarioEntity->getNmUsuario(),
            'email' => $emailEntity->getEmEmail(),
            'txIdentificacao' => base64_encode(\Estrutura\Helpers\Bcrypt::hash($txIdentificacao)),
                ], $applicationService->getModelo('senha-redefinida'));

        $html = new \Zend\Mime\Part($htmlMessage);
        $html->type = 'text/html';

        $body = new \Zend\Mime\Message();
        $body->addPart($html);

        $message->setBody($body);
        $transport->send($message);

        $this->getSessionStorage()->forgetMe();
        $this->getAuthService()->clearIdentity();

        $this->addSuccessMessage('Senha alterada com sucesso.');
        $this->redirect()->toRoute('navegacao', ['controller' => 'auth', 'action' => 'login']);
        return FALSE;
    }

    public function confirmEmailAction()
    {

        $id = base64_decode($this->params('id'));

        if (!$id) {

            $this->addErrorMessage('Token não informado.');
            $this->redirect()->toRoute('navegacao', ['controller' => 'auth', 'action' => 'login']);
            return FALSE;
        }

        $loginService = new \Login\Service\LoginService();
        $loginService->setIdSituacao($this->getConfigList()['situacao_inativo']);
        $listLoginService = $loginService->filtrarObjeto();

        if (!$listLoginService->count()) {

            $this->addSuccessMessage('E-mail confirmado com sucesso.');
            $this->redirect()->toRoute('navegacao', ['controller' => 'auth', 'action' => 'login']);
            return FALSE;
        }

        $confirmEmail = FALSE;
        foreach ($listLoginService as $loginEntityAux) {

            if (crypt($loginEntityAux->getId(), $id) === $id) {

                $loginEntityAux->setIdSituacao($this->getConfigList()['situacao_ativo']);
                $loginEntityAux->salvar();
                $confirmEmail = TRUE;
            }
        }

        if ($confirmEmail) {

            $this->addSuccessMessage('E-mail confirmado com sucesso.');
            $this->redirect()->toRoute('navegacao', ['controller' => 'auth', 'action' => 'login']);
            return FALSE;
        }

        $this->addSuccessMessage('E-mail confirmado com sucesso.');
        $this->redirect()->toRoute('navegacao', ['controller' => 'auth', 'action' => 'login']);
        return FALSE;
    }

}
