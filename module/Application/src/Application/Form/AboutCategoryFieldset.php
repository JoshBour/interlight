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

class AboutCategoryFieldset extends BaseFieldset implements InputFilterProviderInterface
{
    /**
     * The about category fieldset initializer
     */
    public function init()
    {
        parent::__construct("aboutCategory");

        $vocabulary = $this->getVocabulary();

        $this->add(array(
            'name' => 'title',
            'type' => 'text',
            'options' => array(
                'label' => $this->getTranslator()->translate($vocabulary["LABEL_ABOUT_TITLE"])
            ),
            'attributes' => array(
                'placeholder' => $this->getTranslator()->translate($vocabulary["PLACEHOLDER_ABOUT_TITLE"])
            ),
        ));

        $this->add(array(
            'name' => 'content',
            'type' => 'text',
            'options' => array(
                'label' => $this->getTranslator()->translate($vocabulary["LABEL_ABOUT_CONTENT"])
            ),
            'attributes' => array(
                'placeholder' => $this->getTranslator()->translate($vocabulary["PLACEHOLDER_ABOUT_CONTENT"])
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
        return $this->getServiceLocator()->get('aboutCategoryFilter')->getMergedFilters();
    }


} 