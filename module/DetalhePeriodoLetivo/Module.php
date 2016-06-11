<?php
/**
 * Created by PhpStorm.
 * User: IGOR
 * Date: 10/06/2016
 * Time: 13:13
 */
namespace DetalhePeriodoLetivo;

use DetalhePeriodo\Service\DetalhePeriodoService;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module
{
    /**
     *
     */
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }

    /**
     *
     */
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    /**
     *
     */
    public function getAutoloaderConfig()
    {
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
     * @return array
     */
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'DetalhePeriodo\Service\DetalhePeriodoService' => function($sm) {

                    return new DetalhePeriodoService();
                },
            )
        );
    }
}