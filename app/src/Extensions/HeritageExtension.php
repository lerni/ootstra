<?php

namespace App\Extensions;

use SilverStripe\Core\Extension;
use SilverStripe\Model\List\SS_List;

class HeritageExtension extends Extension
{
    public function Heritage($componentName)
    {
        //default state, fallback

        $component = null;

        //hasField, e.g. $db or getter Method
        if ($this->getOwner()->hasField($componentName)) {
            $component = $this->getOwner()->$componentName;
        }

        //hasMethod: all relations or methods
        if ($this->getOwner()->hasMethod($componentName)) {
            $component = $this->getOwner()->$componentName();
        }

        /**
         * @todo: check different kind of return types...
         */
        if (!empty($component) || ($component instanceof SS_List && $component->count())) {
            return $component;
        }

        if ($this->getOwner()->ParentID != 0) {
            return $this->getOwner()->Parent()->Heritage($componentName);
        }
        return false;
    }
}
