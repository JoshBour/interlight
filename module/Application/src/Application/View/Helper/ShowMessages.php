<?php
/**
 * User: Josh
 * Date: 12/9/2013
 * Time: 7:14 μμ
 */

namespace Application\View\Helper;

use Zend\Mvc\Controller\Plugin\FlashMessenger;
use Zend\View\Helper\AbstractHelper;
use Zend\ServiceManager\ServiceManager;

class ShowMessages extends AbstractHelper
{
    /**
     * The service manager
     *
     * @var ServiceManager
     */
    private $serviceManager;

    /**
     * Formats and returns the current messages from flash messenger
     *
     * @return string The formatted message list
     */
    public function __invoke()
    {
        $messages = "";
        $flashMessenger = $this->getServiceManager()->get('ViewHelperManager')->get('flashMessenger');
        if($flashMessenger->hasMessages()){
            $messages = $flashMessenger->render(FlashMessenger::NAMESPACE_DEFAULT,array('flash'));
            $flashMessenger->clearMessages();
        }
        return $messages;
    }

    /**
     * Get the service manager
     *
     * @return ServiceManager
     */
    public function getServiceManager()
    {
        return $this->serviceManager;
    }

    /**
     * Set the service manager
     *
     * @param $serviceManager
     */
    public function setServiceManager($serviceManager){
        $this->serviceManager = $serviceManager;
    }

}