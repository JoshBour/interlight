<?php
/**
 * Created by PhpStorm.
 * User: Josh
 * Date: 4/6/2014
 * Time: 1:44 πμ
 */

namespace Application\Service;

use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\ServiceManagerAwareInterface;
use Application\Service\Cache;
use Zend\Mvc\Controller\Plugin\FlashMessenger;

class BaseService implements ServiceManagerAwareInterface
{

    /**
     * @var Cache
     */
    protected $cacheService;

    /**
     * @var FlashMessenger
     */
    protected $flashMessenger;

    /**
     * The entity manager
     *
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * The info message
     *
     * @var string
     */
    protected $message;

    /**
     * The service manager
     *
     * @var ServiceManager;
     */
    private $serviceManager;

    /**
     * The zend translator
     *
     * @var \Zend\I18n\Translator\Translator
     */
    private $translator;

    /**
     * The application's vocabulary
     *
     * @var array
     */
    private $vocabulary;

//    /**
//     * Magic method used to return entity repositories
//     * @param $name
//     * @param $variables
//     * @return \Doctrine\ORM\EntityRepository
//     */
//    public function __call($name,$variables){
//        $entity = ucfirst(substr($name,3,strlen($name) - 13));
//        $namespace = ucfirst($variables[0]);
//        return $this->getEntityManager()->getRepository("{$namespace}\\Entity\\{$entity}");
//    }

    /**
     * Get the repository for a given entity
     *
     * @param string $namespace
     * @param string $name
     * @return \Doctrine\ORM\EntityRepository
     */
    protected function getRepository($namespace, $name){
        return $this->getEntityManager()->getRepository(ucfirst($namespace) . '\Entity\\' . ucfirst($name));
    }

    /**
     * @return Cache
     */
    protected function getCacheService(){
        if(null === $this->cacheService)
            $this->cacheService = $this->getServiceManager()->get('cache_service');
        return $this->cacheService;
    }

    /**
     * Get the doctrine entity manager
     *
     * @return \Doctrine\ORM\EntityManager
     */
    protected function getEntityManager(){
        if(null === $this->entityManager)
            $this->entityManager = $this->getServiceManager()->get('Doctrine\ORM\EntityManager');
        return $this->entityManager;
    }

    /**
     * Get the flash messenger instance
     *
     * @return FlashMessenger
     */
    protected function getFlashMessenger(){
        if(null == $this->flashMessenger)
            $this->flashMessenger = $this->getServiceManager()->get('ControllerPluginManager')->get('flashMessenger');
        return $this->flashMessenger;
    }

    /**
     * Get the message
     *
     * @return string
     */
    public function getMessage(){
        return $this->message;
    }

    /**
     * Set service manager
     *
     * @param ServiceManager $serviceManager
     */
    public function setServiceManager(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
    }

    /**
     * Get the service manager
     *
     * @return ServiceManager
     */
    protected function getServiceManager()
    {
        return $this->serviceManager;
    }

    /**
     * Get the zend translator
     *
     * @return \Zend\I18n\Translator\Translator
     */
    protected function getTranslator()
    {
        if (null === $this->translator)
            $this->translator = $this->getServiceManager()->get('translator');
        return $this->translator;
    }

    /**
     * Get the application's vocabulary
     *
     * @return array
     */
    protected function getVocabulary(){
        if(null === $this->vocabulary)
            $this->vocabulary = $this->getServiceManager()->get('config')['vocabulary'];
        return $this->vocabulary;
    }
} 