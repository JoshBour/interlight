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

class AttributeFieldset extends BaseFieldset implements InputFilterProviderInterface
{

    public function init()
    {
        parent::__construct('attribute');

        $vocabulary = $this->getVocabulary();

        $this->add(array(
            "name" => "name",
            "type" => "text",
            'options' => array(
                'label' => $this->getTranslator()->translate($vocabulary["LABEL_ATTRIBUTE_NAME"])
            ),
            'attributes' => array(
                'placeholder' => $this->getTranslator()->translate($vocabulary["PLACEHOLDER_ATTRIBUTE_NAME"])
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
        return $this->getServiceLocator()->get('attributeFilter')->getMergedFilters();
    }

} 