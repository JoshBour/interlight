<?php
/**
 * User: Josh
 * Date: 12/9/2013
 * Time: 7:14 μμ
 */

namespace Product\View\Helper;

use Zend\View\Helper\AbstractHelper;

class AttributeSelect extends AbstractHelper
{
    private $attributes;

    private $productAttributes;


    /**
     * Returns a select element based on the given parameters.
     *
     * @param array $collection The entity collection
     * @param string $valueMethod The method to call for the value
     * @param string $textMethod The method to call for the text
     * @param string $excludedId The id to exclude from the options
     * @return string
     */
    public function __invoke($attributes, $productAttributes)
    {
        $this->attributes = $attributes;
        $this->productAttributes = $productAttributes;

        $rendered = sprintf('<div class="attributeSelect">
<select class="attributeList">%s</select>
<div class="attributeTableWrapper">%s</div>
<div class="addAttribute">%s</div>
</div>', $this->renderOptions(), $this->renderAttributeTable(), $this->renderAddButton());

        return $rendered;
    }

    private function renderAddButton()
    {
        return '<span class="button">+ Add Attribute</span>';
    }

    private function renderAttributeTable()
    {
        $tableHead = "<tr>
                        <th>Attribute</th>
                        <th>Value</th>
                        <th>Position</th>
                        <th>Delete</th>
                    </tr>";

        return sprintf('<table class="activeAttributes"><thead>%s</thead><tbody>%s</tbody></table>',$tableHead, $this->renderTableBody());

    }

    private function renderTableBody(){

        $result = "";

        if(!empty($this->productAttributes)) {
            foreach ($this->productAttributes as $productAttribute) {
                $result .= "<tr>";
                $result .= '<td><select class="attributeList" style="display:inline-block">' . $this->renderOptions(false,$productAttribute->getAttribute()->getAttributeId()) . '</select>';
                $result .= '<td><input type="text" name="attributeValue" value="' . $productAttribute->getValue() . '" /></td>';
                $result .= '<td><input type="text" name="attributePosition" value="' . $productAttribute->getPosition() . '" /></td>';
                $result .= '<td><span class="attributeDelete button">Delete</span></td>';
                $result .= "</tr>";
            }
        }
        return $result;
    }

    private function renderOptions($searchAll = false,$option = null)
    {
        $options = "";
        /**
         * @var \Product\Entity\Attribute $attribute
         */
        foreach ($this->attributes as $attribute) {
            $attributeId = $attribute->getAttributeId();
            $selected = $searchAll ? ($this->isSelected($attributeId)? " selected" : "") : $option ? ($option == $attributeId ? " selected" : "") : "";
            $options .= sprintf('<option value="%s"%s>%s</option>',
                $attributeId,
                $selected,
                $attribute->getName());
        }
        return $options;
    }

    private function isSelected($attributeId)
    {
        /**
         * @var \Product\Entity\ProductAttribute $productAttribute
         */
        foreach ($this->productAttributes as $productAttribute) {
            if ($productAttribute->getAttribute()->getAttributeId() == $attributeId)
                return true;
        }
        return false;
    }
}