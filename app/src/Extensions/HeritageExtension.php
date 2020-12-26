<?php

namespace App\Extensions;

use SilverStripe\Core\Extension;
use SilverStripe\ORM\SS_List;

class HeritageExtension extends Extension
{
    public function Heritage($componentName)
    {
        //default state, fallback

        $component = null;

        //hasField, e.g. $db or getter Method
        if ($this->owner->hasField($componentName)) {
            $component = $this->owner->$componentName;
        }

        //hasMethod: all relations or methods
        if ($this->owner->hasMethod($componentName)) {
            $component = $this->owner->$componentName();
        }

        /**
         * @todo: check different kind of return types...
         */
        if (!empty($component) || ($component instanceof SS_List && $component->count())) {
            return $component;
        }

        if ($this->owner->ParentID != 0) {
            return $this->owner->Parent()->Heritage($componentName);
        }
        return false;
    }
}
