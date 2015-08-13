<?php
/**
 * Created by PhpStorm.
 * User: Josh
 * Date: 6/6/2014
 * Time: 2:51 μμ
 */

namespace Product\Form;


use Application\Form\BaseFieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Validator\NotEmpty;
use Zend\Validator\Regex;

class ProductFieldset extends BaseFieldset implements InputFilterProviderInterface
{

    public function init()
    {
        parent::__construct('product');

        $vocabulary = $this->getVocabulary();

        $this->add(array(
            "name" => "productNumber",
            "type" => "text",
            'options' => array(
                'label' => $this->getTranslator()->translate($vocabulary["LABEL_PRODUCT_NUMBER"])
            ),
            'attributes' => array(
                'placeholder' => $this->getTranslator()->translate($vocabulary["PLACEHOLDER_PRODUCT_NUMBER"])
            ),
        ));

        $this->add(array(
            "name" => "name",
            "type" => "text",
            'options' => array(
                'label' => $this->getTranslator()->translate($vocabulary["LABEL_PRODUCT_NAME"])
            ),
            'attributes' => array(
                'placeholder' => $this->getTranslator()->translate($vocabulary["PLACEHOLDER_PRODUCT_NAME"])
            ),
        ));

        $this->add(array(
            "name" => "description",
            "type" => "textarea",
            'options' => array(
                'label' => $this->getTranslator()->translate($vocabulary["LABEL_PRODUCT_DESCRIPTION"])
            ),
            'attributes' => array(
                'placeholder' => $this->getTranslator()->translate($vocabulary["PLACEHOLDER_PRODUCT_DESCRIPTION"])
            ),
        ));

        $this->add(array(
            'type' => 'text',
            'name' => 'attributes',
            'options' => array(
                'object_manager' => $this->getEntityManager(),
                'target_class' => 'Product\Entity\Attribute',
                'label' => $this->getTranslator()->translate($vocabulary["LABEL_PRODUCT_ATTRIBUTES"])
            ),
            'attributes' => array(
                'class' => 'attributeSelect'
            )
        ));

        $this->add(array(
            "name" => "datasheet",
            "type" => "file",
            'options' => array(
                'label' => $this->getTranslator()->translate($vocabulary["LABEL_PRODUCT_DATASHEET"])
            ),
        ));

        $this->add(array(
            "name" => "thumbnail",
            "type" => "file",
            'options' => array(
                'label' => $this->getTranslator()->translate($vocabulary["LABEL_PRODUCT_THUMBNAIL"])
            ),
        ));

        $this->add(array(
            "name" => "specifications",
            "type" => "file",
            'options' => array(
                'label' => $this->getTranslator()->translate($vocabulary["LABEL_PRODUCT_SPECIFICATIONS"])
            ),
        ));

        $this->add(array(
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'relatedProducts',
            'attributes' => array(
                'multiple' => 'multiple',
            ),
            'options' => array(
                'object_manager' => $this->getEntityManager(),
                'target_class' => 'Product\Entity\Product',
                'property' => 'productNumber',
                'disable_inarray_validator' => true,
                'label' => $this->getTranslator()->translate($vocabulary["LABEL_RELATED_PRODUCTS"])
            ),
        ));

        $this->add(array(
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'productVariations',
            'attributes' => array(
                'multiple' => 'multiple',
            ),
            'options' => array(
                'object_manager' => $this->getEntityManager(),
                'target_class' => 'Product\Entity\Product',
                'property' => 'productNumber',
                'disable_inarray_validator' => true,
                'label' => $this->getTranslator()->translate($vocabulary["LABEL_PRODUCT_VARIATIONS"])
            ),
        ));

        $this->add(array(
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'category',
            'options' => array(
                'object_manager' => $this->getEntityManager(),
                'target_class' => 'Product\Entity\Category',
                "empty_option" => $this->getTranslator()->translate($vocabulary['EMPTY_OPTION']),
                'property' => 'name',
                'disable_inarray_validator' => true,
                'label' => $this->getTranslator()->translate($vocabulary["LABEL_PRODUCT_CATEGORY"])
            ),
        ));
    }

    /**
     * Should return an array specification compatible with
     * {@link Zend\InputFilter\Factory::createInputFilter()}.
     *
     * @return array
     */
    public function getInputFilterSpecification()
    {
        $filters = $this->getServiceLocator()->get('productFilter')->getMergedFilters();
        $filters["thumbnail"]["validators"][] = array(
            'name' => 'Application\Validator\Image',
            'options' => array(
                'maxSize' => '40960',
            )
        );
        $filters["specifications"]["validators"][] = array(
            'name' => 'Application\Validator\Image',
            'options' => array(
                'maxSize' => '40960',
            )
        );
        $filters["datasheet"]["validators"][] = array(
            'name' => 'Application\Validator\File',
            'options' => array(
                'maxSize' => '40960',
            )
        );

        return $filters;
    }

} 