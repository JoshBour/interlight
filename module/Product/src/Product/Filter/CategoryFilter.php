<?php
namespace Product\Filter;

use Application\Filter\BaseFilter;
use DoctrineModule\Validator\ObjectExists;
use Zend\Validator\NotEmpty;
use Zend\Validator\Regex;
use Zend\Validator\StringLength;

/**
 * Class CategoryFilter
 * @package Product\Filter
 */
class CategoryFilter extends BaseFilter
{
    public function getMergedFilters(){
        return array_merge($this->getNameFilters(),
            $this->getDescriptionFilters(),
            $this->getParentCategoryFilters(),
            $this->getThumbnailFilters(),
            $this->getPositionFilters());
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
                                NotEmpty::IS_EMPTY => $this->getTranslator()->translate($vocabulary["ERROR_CATEGORY_NAME_EMPTY"])
                            )
                        )
                    ),
                    array(
                        'name' => 'DoctrineModule\Validator\NoObjectExists',
                        'options' => array(
                            'object_repository' => $this->getEntityManager()->getRepository('Product\Entity\Category'),
                            'fields' => 'name',
                            'messages' => array(
                                'objectFound' => $this->getTranslator()->translate($vocabulary["ERROR_CATEGORY_EXISTS"])
                            )
                        )
                    ),
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'min' => 4,
                            'max' => 50,
                            'messages' => array(
                                StringLength::TOO_LONG => $this->getTranslator()->translate($vocabulary["ERROR_CATEGORY_NAME_INVALID_LENGTH"]),
                                StringLength::TOO_SHORT => $this->getTranslator()->translate($vocabulary["ERROR_CATEGORY_NAME_INVALID_LENGTH"])
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

    public function getDescriptionFilters()
    {
        $vocabulary = $this->getVocabulary();
        return array(
            "description" => array(
                'required' => false,
                'validators' => array(
                    array(
                        'name' => 'NotEmpty',
                        'break_chain_on_failure' => true,
                        'options' => array(
                            'messages' => array(
                                NotEmpty::IS_EMPTY => $this->getTranslator()->translate($vocabulary["ERROR_DESCRIPTION_EMPTY"])
                            )
                        )
                    ),
                ),
                'filters' => array(
                    array('name' => 'StringTrim'),
//                    array(
//                        'name' => 'StripTags',
//                        'options' => array(
//                            'allowTags' => array('a', 'br', 'strong', 'del', 'em', 'ul', 'li', 'ol', 'img')
//                        )
//                    )
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
                                NotEmpty::IS_EMPTY => $this->getTranslator()->translate($vocabulary["ERROR_CATEGORY_POSITION_EMPTY"])
                            )
                        )
                    ),
                    array(
                        'name' => 'regex',
                        'options' => array(
                            'pattern' => '/^[0-9]{1,3}$/',
                            'messages' => array(
                                Regex::NOT_MATCH => $this->getTranslator()->translate($vocabulary["ERROR_CATEGORY_POSITION_INVALID"])
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

    public function getParentCategoryFilters()
    {
        $vocabulary = $this->getVocabulary();
        return array(
            "parentCategory" => array(
                'required' => false,
                'validators' => array(
                    array(
                        'name' => 'DoctrineModule\Validator\ObjectExists',
                        'options' => array(
                            'object_repository' => $this->getEntityManager()->getRepository('Product\Entity\Category'),
                            'fields' => 'categoryId',
                            'messages' => array(
                                ObjectExists::ERROR_NO_OBJECT_FOUND => $this->getTranslator()->translate($vocabulary["ERROR_CATEGORY_NOT_EXISTS"])
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
}