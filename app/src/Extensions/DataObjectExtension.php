<?php

namespace App\Extensions;

use SilverStripe\Core\ClassInfo;
use SilverStripe\Core\Extension;
use SilverStripe\ORM\DataObject;
use DNADesign\ElementalVirtual\Model\ElementVirtual;

/**
 * @extends Extension<DataObject>
 */
class DataObjectExtension extends Extension
{
    // we use this in template & WYSIWYGs for css classes
    public function ShortClassName($obj, $lowercase = false)
    {
        $owner = $this->getOwner();
        if ($owner instanceof ElementVirtual) {
            $r = ClassInfo::shortName($owner->LinkedElement()) . ' ' . ClassInfo::shortName(ElementVirtual::class);
        } elseif (!is_object($obj)) {
            $r = ClassInfo::shortName($owner);
        } else {
            $r = ClassInfo::shortName($obj);
        }

        if ($lowercase) {
            $r = strtolower($r);
        }

        return $r;
    }
}
