<?php
/**
 * Created by PhpStorm.
 * User: Josh
 * Date: 4/6/2014
 * Time: 1:56 πμ
 */

namespace Application\Form;


use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Validator\NotEmpty;
use Zend\Validator\Regex;

class SlideFieldset extends BaseFieldset implements InputFilterProviderInterface
{
    /**
     * The partner fieldset initializer
     */
    public function init()
    {
        parent::__construct("slide");

        $vocabulary = $this->getVocabulary();

        $this->add(array(
            'name' => 'url',
            'type' => 'text',
            'options' => array(
                'label' => $this->getTranslator()->translate($vocabulary["LABEL_URL"])
            ),
            'attributes' => array(
                'placeholder' => $this->getTranslator()->translate($vocabulary["PLACEHOLDER_URL"])
            ),
        ));

        $this->add(array(
            'name' => 'position',
            'type' => 'text',
            'options' => array(
                'label' => $this->getTranslator()->translate($vocabulary["LABEL_POSITION"])
            ),
            'attributes' => array(
                'placeholder' => $this->getTranslator()->translate($vocabulary["PLACEHOLDER_POSITION"])
            ),
        ));

        $this->add(array(
            'name' => 'caption',
            'type' => 'text',
            'options' => array(
                'label' => $this->getTranslator()->translate($vocabulary["LABEL_CAPTION"])
            ),
            'attributes' => array(
                'placeholder' => $this->getTranslator()->translate($vocabulary["PLACEHOLDER_CAPTION"])
            ),
        ));

        $this->add(array(
            'name' => 'thumbnail',
            'type' => 'file',
            'options' => array(
                'label' => $this->getTranslator()->translate($vocabulary["LABEL_SLIDE_THUMBNAIL"])
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
        $filters = $this->getServiceLocator()->get('slideFilter')->getMergedFilters();
        $filters["thumbnail"]["validators"][] = array(
            'name' => 'Application\Validator\Image',
            'options' => array(
                'maxSize' => '40960',
            )
        );
        return $filters;
    }


} 