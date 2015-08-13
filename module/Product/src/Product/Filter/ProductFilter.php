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
class ProductFilter extends BaseFilter
{
    public function getMergedFilters(){
        return array_merge($this->getProductNumberFilters(),
            $this->getAttributesFilters(),
            $this->getNameFilters(),
            $this->getDescriptionFilters(),
            $this->getDatasheetFilters(),
            $this->getThumbnailFilters(),
            $this->getSpecificationsFilters(),
            $this->getRelatedProductsFilters(),
            $this->getProductVariationsFilters(),
            $this->getCategoryFilters());
    }

    public function getAttributesFilters(){
        $vocabulary = $this->getVocabulary();
        return array(
            'attributes' => array(
                'required' => true,
                'validators' => array(
                    array(
                        'name' => 'NotEmpty',
                        'break_chain_on_failure' => true,
                        'options' => array(
                            'messages' => array(
                                NotEmpty::IS_EMPTY => $this->getTranslator()->translate($vocabulary["ERROR_PRODUCT_ATTRIBUTES_EMPTY"])
                            )
                        )
                    ),
                    array(
                        'name' => 'Product\Validator\Attribute',
                        'break_chain_on_failure' => true,
                    ),
                ),
            )
        );
    }

    public function getProductNumberFilters()
    {
        $vocabulary = $this->getVocabulary();
        return array(
            'productNumber' => array(
                'required' => true,
                'validators' => array(
                    array(
                        'name' => 'NotEmpty',
                        'break_chain_on_failure' => true,
                        'options' => array(
                            'messages' => array(
                                NotEmpty::IS_EMPTY => $this->getTranslator()->translate($vocabulary["ERROR_PRODUCT_NUMBER_EMPTY"])
                            )
                        )
                    ),
                    array(
                        'name' => 'DoctrineModule\Validator\NoObjectExists',
                        'options' => array(
                            'object_repository' => $this->getEntityManager()->getRepository('Product\Entity\Product'),
                            'fields' => 'productNumber',
                            'messages' => array(
                                'objectFound' => $this->getTranslator()->translate($vocabulary["ERROR_PRODUCT_NUMBER_EXISTS"])
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

    public function getNameFilters()
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
                                NotEmpty::IS_EMPTY => $this->getTranslator()->translate($vocabulary["ERROR_NAME_EMPTY"])
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

    public function getDescriptionFilters()
    {
        $vocabulary = $this->getVocabulary();
        return array(
            "description" => array(
                'required' => true,
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
//                            'allowTags' => array('a','br','strong','del','em','ul','li','ol','img')
//                        )
//                    )
                )
            )
        );
    }

    public function getDatasheetFilters()
    {
        return array(
            "datasheet" => array(
                'required' => false,
            )
        );
    }

    public function getThumbnailFilters()
    {
        return array(
            "thumbnail" => array(
                'required' => false,
            )
        );
    }

    public function getSpecificationsFilters()
    {
        return array(
            "specifications" => array(
                'required' => false,
            )
        );
    }

    public function getRelatedProductsFilters()
    {
        return array(
            "relatedProducts" => array(
                'required' => false,
                'filters' => array(
                    array('name' => 'StringTrim'),
                    array('name' => 'StripTags')
                )
            )
        );
    }

    public function getProductVariationsFilters()
    {
        return array(
            "productVariations" => array(
                'required' => false,
                'filters' => array(
                    array('name' => 'StringTrim'),
                    array('name' => 'StripTags')
                )
            )
        );
    }

    public function getCategoryFilters()
    {
        return array(
            "category" => array(
                'required' => false,
                'filters' => array(
                    array('name' => 'StringTrim'),
                    array('name' => 'StripTags')
                )
            )
        );
    }
}