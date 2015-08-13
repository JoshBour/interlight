<?php
/**
 * User: Josh
 * Date: 12/9/2013
 * Time: 7:14 μμ
 */

namespace Application\View\Helper;

use Zend\View\Helper\AbstractHelper;

class Select extends AbstractHelper
{
    private $collection;

    private $excludedValue;

    private $selected;

    private $emptyOption;

    /**
     * Returns a select element based on the given parameters.
     *
     * @param array $collection The entity collection
     * @param string $valueMethod The method to call for the value
     * @param string $textMethod The method to call for the text
     * @param string $excludedId The id to exclude from the options
     * @return string
     */
    public function __invoke($collection, $excludedValue = null, $selected = null, $emptyOption = false, $multiple = false)
    {
        $this->collection = $collection;
        $this->excludedValue = $excludedValue;
        $this->selected = empty($selected) ? "" : $selected;
        $this->emptyOption = $emptyOption;

//        $class = $class ? ' class="' . $class . '"' : "";

        return sprintf("<select%s>%s</select>", $multiple ? " multiple" : "", $this->renderOptions());
    }

    private function renderOptions()
    {
        $options = "";

        if ($this->emptyOption)
            $options .= sprintf('<option value="">%s</option>',"None");

        foreach ($this->collection as $value => $text) {
            if ($value != $this->excludedValue) {
                $selected = "";
                if($this->selected){
                    $selected = ((is_array($this->selected) && in_array($text,$this->selected)) || $this->selected == $value) ? " selected" : "";
                }
                $options .= sprintf('<option value="%s"%s>%s</option>', $value, $selected, $text);
            }
        }
        return $options;
    }

}