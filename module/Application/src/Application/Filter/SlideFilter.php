<?php
namespace Application\Filter;

use Application\Filter\BaseFilter;
use Application\Validator\Image;
use DoctrineModule\Validator\ObjectExists;
use Zend\Validator\NotEmpty;
use Zend\Validator\Regex;
use Zend\Validator\StringLength;
use Zend\Validator\Uri;

/**
 * Class CategoryFilter
 * @package Product\Filter
 */
class SlideFilter extends BaseFilter
{
    public function getMergedFilters(){
        return array_merge($this->getUrlFilters(),$this->getCaptionFilters(),$this->getPositionFilters(),$this->getThumbnailFilters());
    }

    protected function getUrlFilters()
    {
        $vocabulary = $this->getVocabulary();
        return array(
            "url" => array(
                'required' => true,
                'validators' => array(
                    array(
                        'name' => 'NotEmpty',
                        'break_chain_on_failure' => true,
                        'options' => array(
                            'messages' => array(
                                NotEmpty::IS_EMPTY => $this->getTranslator()->translate($vocabulary["ERROR_URL_EMPTY"])
                            )
                        )
                    ),
                    array(
                        'name' => 'Zend\Validator\Uri',
                        'options' => array(
                            'messages' => array(
                                Uri::INVALID => $this->getTranslator()->translate($vocabulary["ERROR_INVALID_URL"]),
                                Uri::NOT_URI => $this->getTranslator()->translate($vocabulary["ERROR_INVALID_URL"])
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

    public function getPositionFilters()
    {
        $vocabulary = $this->getVocabulary();
        return array(
            "position" => array(
                'required' => true,
                'validators' => array(
                    array(
                        'name' => 'NotEmpty',
                        'break_chain_on_failure' => true,
                        'options' => array(
                            'messages' => array(
                                NotEmpty::IS_EMPTY => $this->getTranslator()->translate($vocabulary["ERROR_POSITION_EMPTY"])
                            )
                        )
                    ),
                    array(
                        'name' => 'regex',
                        'options' => array(
                            'pattern' => '/^[0-9]{1,3}$/',
                            'messages' => array(
                                Regex::NOT_MATCH => $this->getTranslator()->translate($vocabulary["ERROR_POSITION_INVALID"])
                            )
                        )
                    ),
                ),
                'filters' => array(
                    array('name' => 'StringTrim'),
                    array('name' => 'StripTags')
                )
            )
        );
    }

    public function getCaptionFilters()
    {
        $vocabulary = $this->getVocabulary();
        return array(
            "caption" => array(
                'required' => true,
                'validators' => array(
                    array(
                        'name' => 'NotEmpty',
                        'break_chain_on_failure' => true,
                        'options' => array(
                            'messages' => array(
                                NotEmpty::IS_EMPTY => $this->getTranslator()->translate($vocabulary["ERROR_CAPTION_EMPTY"])
                            )
                        )
                    ),

                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'min' => 4,
                            'max' => 100,
                            'messages' => array(
                                StringLength::TOO_LONG => $this->getTranslator()->translate($vocabulary["ERROR_CAPTION_INVALID_LENGTH"]),
                                StringLength::TOO_SHORT => $this->getTranslator()->translate($vocabulary["ERROR_CAPTION_INVALID_LENGTH"])
                            )
                        )
                    ),
                ),
                'filters' => array(
                    array('name' => 'StringTrim'),
                    array('name' => 'StripTags')
                )
            )
        );
    }

    public function getThumbnailFilters()
    {
        $vocabulary = $this->getVocabulary();
        return array(
            "thumbnail" => array(
                'required' => true,
                'validators' => array(
                    array(
                        'name' => 'NotEmpty',
                        'break_chain_on_failure' => true,
                        'options' => array(
                            'messages' => array(
                                NotEmpty::IS_EMPTY => $this->getTranslator()->translate($vocabulary["ERROR_THUMBNAIL_EMPTY"])
                            )
                        )
                    ),
                ),
            )
        );
    }
}