<?php
/**
 * User: Josh
 * Date: 12/9/2013
 * Time: 7:14 μμ
 */

namespace Product\View\Helper;

use Zend\View\Helper\AbstractHelper;

class ProductSelect extends AbstractHelper
{
    private $products;

    private $selectedProducts;


    /**
     * Returns a select element based on the given parameters.
     *
     * @param array $collection The entity collection
     * @param string $valueMethod The method to call for the value
     * @param string $textMethod The method to call for the text
     * @param string $excludedId The id to exclude from the options
     * @return string
     */
    public function __invoke($products, $selectedProducts)
    {
        $this->products = $products;
        $this->selectedProducts = $selectedProducts;

        $rendered = sprintf('<div class="attributeSelect">
<select class="attributeList">%s</select>
<div class="attributeTableWrapper">%s</div>
<div class="addAttribute">%s</div>
</div>', $this->renderOptions(), $this->renderAttributeTable(), $this->renderAddButton());

        return $rendered;
    }

    private function renderAddButton()
    {
        return '<span class="button">+ Add Product</span>';
    }

    private function renderAttributeTable()
    {
        $tableHead = "<tr>
                        <th>Product Number</th>
                        <th>Delete</th>
                    </tr>";

        return sprintf('<table class="activeAttributes"><thead>%s</thead><tbody>%s</tbody></table>', $tableHead, $this->renderTableBody());

    }

    private function renderTableBody()
    {

        $result = "";
        if (!empty($this->selectedProducts)) {
            foreach ($this->selectedProducts as $product) {
                $result .= "<tr>";
                $result .= '<td><select class="attributeList" style="display:inline-block">' . $this->renderOptions($product) . '</select>';
                $result .= '<td><span class="attributeDelete button">Delete</span></td>';
                $result .= "</tr>";
            }
        }
        return $result;
    }

    private function renderOptions($selected = false)
    {
        $options = "";
        /**
         * @var \Product\Entity\Product $product
         */
        foreach ($this->products as $value => $text) {
            $options .= '<option value="' . $value . '"';
            if ($selected && $selected == $text)
                $options .= ' selected';
            $options .= '>' . $text . '</option>';
        }
        return $options;
    }
}