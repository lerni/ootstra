<?php

namespace App\Extensions;

use SilverStripe\Core\ClassInfo;
use SilverStripe\Core\Extension;
use DNADesign\ElementalVirtual\Model\ElementVirtual;


class DataObjectExtension extends Extension
{
    // we use this in template & WYSIWYGs for css classes
    public function ShortClassName($obj, $lowercase = false)
    {
        if ($this->owner->ClassName == ElementVirtual::class) {
            $r = ClassInfo::shortName($this->owner->LinkedElement()) . ' ' . ClassInfo::shortName(ElementVirtual::class);
        } elseif (!is_object($obj)) {
            $r = ClassInfo::shortName($this->owner);
        } else {
            $r = ClassInfo::shortName($obj);
        }

        if ($lowercase) {
            $r = strtolower($r);
        }
        return $r;
    }
}
