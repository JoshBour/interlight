<?php
namespace Application\Factory;

use Application\View\Helper\ShowMessages;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ShowMessagesHelperFactory implements FactoryInterface{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {

        $helper = new ShowMessages();
        $helper->setServiceManager($serviceLocator->getServiceLocator());
        return $helper;
    }

}

