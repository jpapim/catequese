<?php

namespace Application;

use Estrutura\Form\AbstractForm;
use Estrutura\Service\AbstractEstruturaService;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module {

    /**
     * 
     * @return type
     */
    public function getAutoloaderConfig() {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    /**
     * 
     * @return type
     */
    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }

    /**
     * 
     * @param \Zend\Mvc\MvcEvent $e
     */
    public function onBootstrap(MvcEvent $e) {
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        //ACL
        $this->initAcl($e);

        $moduleManager = $e->getApplication()->getServiceManager()->get('modulemanager');
        $sharedEvents = $moduleManager->getEventManager()->getSharedManager();
        $sharedEvents->attach('Zend\Mvc\Controller\AbstractController', MvcEvent::EVENT_DISPATCH, array(
            $this,
            'controllerDispatch'
                ), 100
        );

        //Set web browser preferred language 
        $translator = $e->getApplication()->getServiceManager()->get('translator');
        $translator->setLocale($this->getLanguageCodeISO6391())->setFallbackLocale('pt_BR');
    }

    /**
     * 
     * @param \Zend\Mvc\MvcEvent $e
     */
    public function initAcl(MvcEvent $e) {
        $acl = new \Zend\Permissions\Acl\Acl();
        $aclService = new \Auth\Service\AclService();
        $aclService->setServiceManager($e->getApplication()->getServiceManager());

        $cache = $aclService->getServiceLocator()->get('Zend\Cache\Storage\Filesystem');

        $queryCache = $cache->getItem('applicationModuleInitAcl', $success);

        if (!$success) {

            $roles = $aclService->getDbRoles();

            foreach ($roles as $role => $resources) {

                $role = new \Zend\Permissions\Acl\Role\GenericRole($role);
                $acl->addRole($role);

                //adding resources
                foreach ($resources as $resource) {

                    if (!$acl->hasResource($resource)) {

                        $acl->addResource(new \Zend\Permissions\Acl\Resource\GenericResource($resource));
                    }
                }

                //adding restrictions
                foreach ($resources as $resource) {

                    $acl->allow($role, $resource);
                }
            }

            $cache->addItem('applicationModuleInitAcl', $acl);
        } else {

            $acl = $queryCache;
        }

        $e->getViewModel()->acl = $acl;
    }

    /**
     * Get web browser preferred language 
     */
    public function getLanguageCodeISO6391() {
        $langs = explode(",", $_SERVER['HTTP_ACCEPT_LANGUAGE']);
        foreach ($langs as $lang) {

            $linguage = explode(";", $lang);

            if (!isset($linguage[1])) {

                return str_replace('-', '_', $linguage[0]);
            } elseif ($linguage[1] == 1) {

                return str_replace('-', '_', $linguage[0]);
            }
        }
    }

    /**
     * @param MvcEvent $e
     * @return null|\Zend\Http\PhpEnvironment\Response
     */
    public function controllerDispatch(MvcEvent $e) {
        $locator = $e->getTarget()->getServiceLocator();
        AbstractEstruturaService::setServiceManager($locator);
        AbstractForm::setServiceManager($locator);

        $route = $e->getTarget()->getEvent()->getRouteMatch()->getParams();
        $controller = $e->getTarget();

        if (($controller->getRequest() instanceof ConsoleRequest) ||
                ($route['controller'] == 'site') ||
                ($route['controller'] == 'auth') ||
                ($route['controller'] == 'gerador') ||
                ($route['controller'] == 'compactasset-index')) {

            return true;
        }

        if ($route['controller'] == 'usuario') {
            if (($route['action'] == 'cadastro') ||
                    ($route['action'] == 'gravar') ||
                    ($route['action'] == 'captcha')) {
                return true;
            }
        }

        if (!$locator->get('AuthService')->hasIdentity()) {

            $translate = $locator->get('viewhelpermanager')->get('translate');
            $controller->addInfoMessage($translate('Please login to use the system.', 'Auth'));
            return $controller->redirect()->toRoute('login');
        } else {
            $this->checkAcl($e);
        }
    }

    /**
     * 
     * @param \Zend\Mvc\MvcEvent $e
     */
    public function checkAcl(MvcEvent $e) {

        $route = $e->getTarget()->getEvent()->getRouteMatch()->getParams();
        $resource = $route['controller'] . '/' . $route['action'];

        $myAuth = $e->getTarget()->getServiceLocator()->get('AuthService')->getStorage()->read();
        $e->getViewModel()->role = $myAuth->id_perfil;

        if (!($e->getViewModel()->acl->hasResource($resource) &&
                $e->getViewModel()->acl->isAllowed($e->getViewModel()->role, $resource))) {

            $translate = $e->getTarget()->getServiceLocator()->get('viewhelpermanager')->get('translate');
            echo utf8_decode($translate('You do not have permission to access this page.', 'Auth') . ' erro: ' . $resource);
            exit;
        }
    }
}
