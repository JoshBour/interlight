<?php
namespace Product\Form\Helper;

use \Zend\Form\Exception\DomainException;
use \Zend\Form\ElementInterface;

/**
 * Created by PhpStorm.
 * User: Josh
 * Date: 25/7/2015
 * Time: 10:09 μμ
 */
class AttributeSelect extends \Zend\Form\View\Helper\AbstractHelper
{
    /**
     * Invoke helper as functor
     *
     * Proxies to {@link render()}.
     *
     * @param  ElementInterface|null $element
     * @param array|null $encodedAttributes
     * @return string|
     */
    public function __invoke(ElementInterface $element = null, $encodedAttributes = null)
    {
        if (!$element) {
            return $this;
        }

        return $this->render($element,$encodedAttributes);
    }

    /**
     * Render a form <select> element from the provided $element
     *
     * @param  ElementInterface $element
     * @param array $encodedAttributes
     * @throws DomainException
     * @return string
     */
    public function render(\Zend\Form\ElementInterface $element, $encodedAttributes)
    {
//        if (!$element instanceof SelectElement) {
//            throw new Exception\InvalidArgumentException(sprintf(
//                '%s requires that the element is of type Zend\Form\Element\Select',
//                __METHOD__
//            ));
//        }

        $name = $element->getName();
        if (empty($name) && $name !== 0) {
            throw new DomainException(sprintf(
                '%s requires that the element has an assigned name; none discovered',
                __METHOD__
            ));
        }

//        var_dump($element->getMessages());

        $options = $element->getOptions();

        $attributeList = $this->renderAttributeList($options);

        $rendered = sprintf('<div class="attributeSelect">' .
                '<select class="attributeList">%s</select>' .
                '<div class="attributeTableWrapper">' .
                    '<table class="activeAttributes">
                        <thead>
                            <tr>
                                <th>Attribute</th>
                                <th>Value</th>
                                <th>Position</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>%s</tbody>
                    </table>' .
                '</div>' .
                '<div class="addAttribute">' .
                    '<span class="button">+ Add Attribute</span>' .
                '</div>' .
            '</div>',

            $attributeList,
            $this->renderEncodedAttributes($encodedAttributes,$options));


        return $rendered;
    }

    public function renderEncodedAttributes($encodedAttributes, $options){

        $result = "";

        if(!empty($encodedAttributes)) {
            $attributes = json_decode($encodedAttributes,true);
            foreach ($attributes as $attribute) {
                $result .= "<tr>";
                $result .= '<td><select class="attributeList" style="display:inline-block">' . $this->renderAttributeList($options,$attribute['attributeId']) . '</select>';
                $result .= '<td><input type="text" name="attributeValue" value="' . $attribute['value'] . '" /></td>';
                $result .= '<td><input type="text" name="attributePosition" value="' . $attribute['position'] . '" /></td>';
                $result .= '<td><span class="attributeDelete button">Delete</span></td>';
                $result .= "</tr>";
            }
        }
        return $result;
    }

    public function renderAttributeList($options, $selected = null){
        /**
         * @var \Doctrine\ORM\EntityManager $entityManager
         */
        $entityManager = $options['object_manager'];
        $class = $options['target_class'];
        $entities = $entityManager->getRepository($class)->findAll();
        $output = "";
        foreach($entities as $entity){
            if(!$entity instanceof \Product\Entity\Attribute) throw new \InvalidArgumentException();
            $id = $entity->getAttributeId();

            $output .= '<option value="' . $id . '"';
            if($selected && $selected == $id)
                $output .= ' selected';
            $output .= '>' . $entity->getName() . '</option>';

        }
        return $output;
    }
}