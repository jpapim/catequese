<?php

namespace Auth;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module implements AutoloaderProviderInterface {

    /**
     * 
     * @return type
     */
    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }

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
    public function getViewHelperConfig() {
        return array(
            'factories' => array(
                'Auth' => function($sm) {
                    $auth = new \Auth\View\Helper\Auth();
                    $auth->setServiceManager($sm);
                    return $auth;
                }
            ),
        );
    }

    /**
     * 
     * @return type
     */
    public function getServiceConfig() {
        return array(
            'factories' => array(
                'Auth\Table\MyAuth' => function($sm) {

                    return new \Auth\Table\MyAuth('auth');
                },
                'AuthService' => function($sm) {

                    $authService = new \Auth\Service\AuthService();
                    $authService->setServiceManager($sm);
                    return $authService->autenticar();
                }
            )
        );
    }

    /**
     * 
     * @param \Zend\Mvc\MvcEvent $e
     */
    public function onBootstrap(MvcEvent $e) {
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        $localeFromHttp = $_SERVER['HTTP_ACCEPT_LANGUAGE'];

        if (false === stripos($localeFromHttp, '-')) {

            $locale = $localeFromHttp . '_' . strtoupper($localeFromHttp);
        } else {

            $locale = $localeFromHttp;
        }

        $translator = $e->getApplication()->getServiceManager()->get('translator');
        $translator->setLocale($locale)->setFallbackLocale('pt_BR');
    }

}
