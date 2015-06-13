<?php
/**
 * Created by PhpStorm.
 * User: Josh
 * Date: 1/6/2014
 * Time: 8:11 μμ
 */

namespace Application\Controller;

use Application\Initializer\EntityManagerAwareInterface;
use Application\Initializer\VocabularyAwareInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Application\Service\BaseService;

class BaseController extends AbstractActionController implements EntityManagerAwareInterface, VocabularyAwareInterface
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $entityManager;

    /**
     * @var array
     */
    protected $vocabulary;

    /**
     * Get the entity manager
     *
     * @return \Doctrine\ORM\EntityManager
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * Set the entity manager
     *
     * @param \Doctrine\ORM\EntityManager $entityManager
     */
    public function setEntityManager($entityManager)
    {
        $this->entityManager = $entityManager;
    }

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
     * @param $formName
     * @return \Zend\Form\Form
     */
    protected function getForm($formName){
        return $this->getServiceLocator()->get($formName . 'Form');
    }

    /**
     * @param $name
     * @return BaseService
     */
    protected function getService($name){
        return $this->getServiceLocator()->get(($name) . 'Service');
    }

    /**
     * @param array $vocabulary
     */
    public function setVocabulary($vocabulary)
    {
        $this->vocabulary = $vocabulary;
    }

    /**
     * @return array
     */
    public function getVocabulary()
    {
        return $this->vocabulary;
    }


} 