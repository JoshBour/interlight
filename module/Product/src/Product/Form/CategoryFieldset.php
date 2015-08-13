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
use Zend\Validator\File\Size;
use Zend\Validator\Regex;

class CategoryFieldset extends BaseFieldset implements InputFilterProviderInterface
{

    public function init()
    {
        parent::__construct('category');

        $vocabulary = $this->getVocabulary();

        $this->add(array(
            "name" => "name",
            "type" => "text",
            'options' => array(
                'label' => $this->getTranslator()->translate($vocabulary["LABEL_CATEGORY_NAME"])
            ),
            'attributes' => array(
                'placeholder' => $this->getTranslator()->translate($vocabulary["PLACEHOLDER_CATEGORY_NAME"])
            ),
        ));

        $this->add(array(
            "name" => "description",
            "type" => "textarea",
            'options' => array(
                'label' => $this->getTranslator()->translate($vocabulary["LABEL_CATEGORY_DESCRIPTION"])
            ),
            'attributes' => array(
                'placeholder' => $this->getTranslator()->translate($vocabulary["PLACEHOLDER_CATEGORY_DESCRIPTION"])
            ),
        ));

        $this->add(array(
            "name" => "thumbnail",
            "type" => "file",
            'options' => array(
                'label' => $this->getTranslator()->translate($vocabulary["LABEL_CATEGORY_THUMBNAIL"])
            ),
        ));

        $this->add(array(
            "name" => "position",
            "type" => "text",
            'options' => array(
                'label' => $this->getTranslator()->translate($vocabulary["LABEL_CATEGORY_POSITION"])
            ),
            'attributes' => array(
                'placeholder' => $this->getTranslator()->translate($vocabulary["PLACEHOLDER_CATEGORY_POSITION"])
            ),
        ));

        $this->add(array(
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'parentCategory',
            'options' => array(
                'label' => $this->getTranslator()->translate($vocabulary["LABEL_CATEGORY_PARENT_CATEGORY"]),
                'object_manager' => $this->getEntityManager(),
                'empty_option' => $this->getTranslator()->translate($vocabulary["EMPTY_OPTION"]),
                'target_class' => 'Product\Entity\Category',
                'property' => 'name',
                'disable_inarray_validator' => true
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
        $filters = $this->getServiceLocator()->get('categoryFilter')->getMergedFilters();
        $filters["thumbnail"]["validators"][] = array(
            'name' => 'Application\Validator\Image',
            'options' => array(
                'maxSize' => '40960',
            )
        );
        return $filters;
    }

} 