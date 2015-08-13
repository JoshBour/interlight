<?php
/**
 * Created by PhpStorm.
 * User: Josh
 * Date: 4/6/2014
 * Time: 1:56 πμ
 */

namespace Post\Form;


use Application\Form\BaseFieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Validator\File\Size;
use Zend\Validator\NotEmpty;
use Zend\Validator\Regex;
use Zend\Validator\StringLength;

class PostFieldset extends BaseFieldset implements InputFilterProviderInterface
{

    /**
     * The post fieldset initializer
     */
    public function init()
    {
        parent::__construct("post");

        $vocabulary = $this->getVocabulary();

        $this->add(array(
            'name' => 'thumbnail',
            'type' => 'file',
            'options' => array(
                'label' => $this->getTranslator()->translate($vocabulary["LABEL_POST_THUMBNAIL"])
            ),
        ));

        $this->add(array(
            'name' => 'title',
            'type' => 'text',
            'options' => array(
                'label' => $this->getTranslator()->translate($vocabulary["LABEL_POST_TITLE"])
            ),
            'attributes' => array(
                'placeholder' => $this->getTranslator()->translate($vocabulary["PLACEHOLDER_POST_TITLE"])
            ),

        ));

        $this->add(array(
            'name' => 'content',
            'type' => 'text',
            'options' => array(
                'label' => $this->getTranslator()->translate($vocabulary["LABEL_POST_CONTENT"])
            ),
            'attributes' => array(
                'placeholder' => $this->getTranslator()->translate($vocabulary["PLACEHOLDER_POST_CONTENT"])
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
        $filters = $this->getServiceLocator()->get('postFilter')->getMergedFilters();
        $filters["thumbnail"]["validators"][] = array(
            'name' => 'Application\Validator\Image',
            'options' => array(
                'maxSize' => '40960',
            )
        );
        return $filters;
    }


} 