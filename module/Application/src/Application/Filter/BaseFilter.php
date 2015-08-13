<?php
namespace Application\Filter;

use Zend\InputFilter\Factory;
use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\ServiceManagerAwareInterface;

/**
 * Class BaseFilter
 * @package Product\Filter
 */
abstract class BaseFilter implements ServiceManagerAwareInterface
{
    /**
     * The entity manager
     *
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

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

    abstract function getMergedFilters();

    public function filter($name,$data)
    {
        // maybe check if the function exists first
        $filterArray = $this->{'get'.ucfirst($name).'Filters'}();
        $factory = new Factory();
        $filter = $factory->createInputFilter($filterArray);
        $filter->setData(array($name => $data));
        return $filter;
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