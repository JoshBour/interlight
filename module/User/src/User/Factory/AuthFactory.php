<?php
namespace User\Factory;


use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AuthFactory implements FactoryInterface{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $authService = $serviceLocator->get('doctrine.authenticationservice.orm_default');
        $authStorage = $serviceLocator->get('authStorage');
//        $authStorage->init();
        $authService->setStorage($authStorage);
        return $authService;
    }

} 