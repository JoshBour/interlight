<?php
namespace Application\Filter;

use Application\Filter\BaseFilter;
use DoctrineModule\Validator\ObjectExists;
use Zend\Validator\NotEmpty;
use Zend\Validator\Regex;
use Zend\Validator\StringLength;
use Zend\Validator\Uri;

/**
 * Class CategoryFilter
 * @package Product\Filter
 */
class ContentFilter extends BaseFilter
{
    public function getMergedFilters(){
        return $this->getContentFilters();
    }

    public function getContentFilters()
    {
        $vocabulary = $this->getVocabulary();
        return array(
            "content" => array(
                'required' => true,
                'validators' => array(
                    array(
                        'name' => 'NotEmpty',
                        'break_chain_on_failure' => true,
                        'options' => array(
                            'messages' => array(
                                NotEmpty::IS_EMPTY => $this->getTranslator()->translate($vocabulary["ERROR_CONTENT_EMPTY"])
                            )
                        )
                    ),
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'min' => 4,
                            'messages' => array(
                                StringLength::TOO_SHORT => $this->getTranslator()->translate($vocabulary["ERROR_ABOUT_CONTENT_INVALID_LENGTH"])
                            )
                        )
                    ),
                ),
                'filters' => array(
                    array('name' => 'StringTrim'),
                )
            )
        );
    }
}