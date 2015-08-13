<?php
namespace Product\Filter;

use Application\Filter\BaseFilter;
use DoctrineModule\Validator\ObjectExists;
use Zend\Validator\NotEmpty;
use Zend\Validator\Regex;
use Zend\Validator\StringLength;

/**
 * Class AttributeFilter
 * @package Product\Filter
 */
class AttributeFilter extends BaseFilter
{
    public function getMergedFilters(){
        return $this->getNameFilters();
    }

    protected function getNameFilters()
    {
        $vocabulary = $this->getVocabulary();
        return array(
            "name" => array(
                'required' => true,
                'validators' => array(
                    array(
                        'name' => 'NotEmpty',
                        'break_chain_on_failure' => true,
                        'options' => array(
                            'messages' => array(
                                NotEmpty::IS_EMPTY => $this->getTranslator()->translate($vocabulary["ERROR_ATTRIBUTE_NAME_EMPTY"])
                            )
                        )
                    ),
                    array(
                        'name' => 'DoctrineModule\Validator\NoObjectExists',
                        'options' => array(
                            'object_repository' => $this->getEntityManager()->getRepository('Product\Entity\Attribute'),
                            'fields' => 'name',
                            'messages' => array(
                                'objectFound' => $this->getTranslator()->translate($vocabulary["ERROR_ATTRIBUTE_EXISTS"])
                            )
                        )
                    ),
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'min' => 4,
                            'max' => 100,
                            'messages' => array(
                                StringLength::TOO_LONG => $this->getTranslator()->translate($vocabulary["ERROR_ATTRIBUTE_NAME_INVALID_LENGTH"]),
                                StringLength::TOO_SHORT => $this->getTranslator()->translate($vocabulary["ERROR_ATTRIBUTE_NAME_INVALID_LENGTH"])
                            )
                        )
                    ),
                ),
                'filters' => array(
                    array('name' => 'StringTrim'),
                    array('name' => 'StripTags')
                )
            ));
    }

}