<?php
namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Session\Container;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $application = $e->getApplication();
        $eventManager        = $application->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        $translator = $application->getServiceManager()->get('translator');
        $translator -> setLocale('en_US');
//        $translator->setLocale(\Locale::acceptFromHttp($_SERVER['HTTP_ACCEPT_LANGUAGE']));
//            ->setFallbackLocale('el_GR');
        $this->bootstrapSession($e);
    }

    public function bootstrapSession(MvcEvent $e){
        /**
         * @var \Zend\Session\SessionManager $session
         */
        $session = $e->getApplication()
            ->getServiceManager()
            ->get('Zend\Session\SessionManager');

        $session->start();
        $container = new Container('initialized');
        if(!isset($container->init)){
            $session->regenerateId(true);
            $container->init = 1;
        }
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
}
