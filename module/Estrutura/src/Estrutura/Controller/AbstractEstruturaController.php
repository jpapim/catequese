<?php

/**
 * Classe de abstração para as controllers do sistema
 * Define as funções principais do sistema
 */

namespace Estrutura\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container;

abstract class AbstractEstruturaController extends AbstractActionController {

    protected $service = null;
    protected $form = null;
    protected $configList = null;

    public function init() {
        $this->setServiceObj();
        $this->setFormObj();
    }

    public function setServiceObj() {
        if (!$this->service) {
            $this->service = $this->getServiceObj();
        }
    }

    public function setFormObj() {
        if (!$this->form) {
            $this->form = $this->getFormObj();
        }
    }

    public function getConfigList() {
        if (!$this->configList) {
            $this->configList = $this->getServiceLocator()
                ->get('Config\Service\ConfigService')
                ->getConfigList();
        }
        return $this->configList;
    }

    public function getServiceObj() {
        $classe = get_class($this);

        $explode = explode('\\', $classe);

        ///Extrai os dados para variaveis
        list($namespace, $tipo, $controller) = $explode;

        // Se controller for index seta o service do namespace
        if ($controller == 'IndexController') {

            $obj = str_replace(['Controller', 'IndexService'], ['Service', $namespace], $classe);

        } else if($controller == 'ControllerController'){ // Alysson - Corrigindo caso for acessar o cadastro de Controller

            $obj = "\\" . $namespace . '\Service\\' .  'ControllerService';
        } else { // Se nao ele seta da controller

            $objeto = str_replace('Controller', '', $controller);
            $obj = "\\" . $namespace . '\Service\\' . $objeto . 'Service';
        }

        #xd($obj);
        $service = new $obj;
        return $service;
    }

    public function getFormObj() {

        $classe = get_class($this);
        $explode = explode('\\', $classe);

        ///Extrai os dados para variaveis
        list($namespace, $tipo, $controller) = $explode;

        // Se controller for index seta o service do namespace
        if ($controller == 'IndexController') {

            $obj = str_replace(['Controller', 'IndexForm'], ['Form', $namespace], $classe);

            // Se nao ele seta da controller
        } else if($controller == 'ControllerController'){ // Alysson - Corrigindo caso for acessar o cadastro de Controller
            $obj = "\\" . $namespace . '\Form\\' .  'ControllerForm';

        } else {

            $objeto = str_replace('Controller', '', $controller);
            $obj = "\\" . $namespace . '\Form\\' . $objeto . 'Form';
        }

        $form = new $obj;
        return $form;
    }

    public function baseUrl() {
        return BASE_URL;
    }

    public function getPost() {
        $container = new Container('Post');
        $dados = $container->offsetGet('dados');
        $container->offsetUnset('dados');

        return $dados;
    }

    public function setPost($post) {
        $container = new Container('Post');
        $container->offsetSet('dados', $post);
    }

    public function addErrorMessage($message) {
        if (!is_array($message)) {
            $message = array($message);
        }

        foreach ($message as $msg) {
            $arrErros = $this->flashMessenger()->getCurrentErrorMessages();
            if (!in_array($msg, $arrErros)) {
                $this->flashMessenger()->addErrorMessage($msg);
            }
        }
        return;
    }

    public function addSuccessMessage($message) {
        if (!is_array($message)) {
            $message = array($message);
        }

        foreach ($message as $msg) {
            $arrSuccess = $this->flashMessenger()->getCurrentSuccessMessages();
            if (!in_array($msg, $arrSuccess)) {
                $this->flashMessenger()->addSuccessMessage($msg);
            }
        }
        return;
    }

    public function addInfoMessage($message) {
        if (!is_array($message)) {
            $message = array($message);
        }

        foreach ($message as $msg) {
            $arrInfo = $this->flashMessenger()->getCurrentInfoMessages();
            if (!in_array($msg, $arrInfo)) {

                $this->flashMessenger()->addInfoMessage($msg);
            }
        }
    }

    public function addValidateMessages(\Zend\Form\Form $form) {
        $arrMsgs = $form->getMessages();

        if (!is_array($arrMsgs)) {
            return;
        }
        foreach ($arrMsgs as $atributo => $mensagens) {
            foreach ($mensagens as $mensagem) {
                $attr = $form->get($atributo)->getLabel() ? $form->get($atributo)->getLabel() : $atributo;
                $mensagemPro = 'O Campo ' . $attr . ' é de preenchimento obrigatório';
                $this->addErrorMessage($mensagemPro);
            }
        }
    }

    /**
     *
     * @return type
     */
    public function getCurrentPage() {

        $currentPage = $this->getRequest()->getPost()->get('current_page');
        return ($currentPage ? $currentPage : 1);
    }

    /**
     *
     * @return type
     */
    public function getCountPerPage($countPerPageAttr = 100) {

        $countPerPage = (int) $this->getRequest()->getPost()->get('count_per_page');
        return (($countPerPage && ($countPerPage < 5000)) ? $countPerPage : $countPerPageAttr);
    }

    /**
     *
     * @return type
     */
    public function getFilterPage() {

        return $this->getRequest()->getPost()->get('filter_page');
    }

}
