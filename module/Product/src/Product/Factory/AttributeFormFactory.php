<?php
/**
 * Created by PhpStorm.
 * User: Josh
 * Date: 6/6/2014
 * Time: 3:27 μμ
 */

namespace Product\Factory;


use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Product\Entity\Attribute;
use Product\Form\AttributeFieldset;
use Product\Form\AttributeForm;
use Zend\InputFilter\InputFilter;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AttributeFormFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /**
         * @var \Doctrine\ORM\EntityManager $entityManager
         */
        $entityManager = $serviceLocator->get('Doctrine\ORM\EntityManager');
        $formManager = $serviceLocator->get('FormElementManager');
        /**
         * @var AttributeFieldset $fieldset
         */
        $fieldset = $formManager->get('Product\Form\AttributeFieldset');
        $form = new AttributeForm();
        $hydrator = new DoctrineHydrator($entityManager, '\Product\Entity\Attribute');

        $fieldset->setUseAsBaseFieldset(true)
            ->setHydrator($hydrator)
            ->setObject(new Attribute());

        $form->add($fieldset)
            ->setInputFilter(new InputFilter())
            ->setHydrator($hydrator);

        return $form;
    }

} 