<?php
/**
 * User: Josh
 * Date: 12/9/2013
 * Time: 7:14 μμ
 */

namespace Application\View\Helper;

use Zend\View\Helper\AbstractHelper;

class GenerateSelect extends AbstractHelper
{
    /**
     * Returns a select element based on the given parameters.
     *
     * @param array $collection The entity collection
     * @param string $valueMethod The method to call for the value
     * @param string $textMethod The method to call for the text
     * @param string $excludedId The id to exclude from the options
     * @return string
     */
    public function __invoke($collection, $valueMethod, $textMethod, $excludedId, $includeEmptyOption = false)
    {
        $select = "<select>";
        if($includeEmptyOption){
            $select .= '<option value="">None</option>';
        }
        foreach ($collection as $entity) {
            $entityId = $entity->{'get' . ucfirst($valueMethod)}();
            if ($entityId != $excludedId)
                $select .= '<option value="' . $entityId . '">' . $entity->{'get' . ucfirst($textMethod)}() . '</option>';
        }
        $select .= "</select>";
        return $select;
    }

}