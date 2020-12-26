<?php

namespace App\Extensions;

use SilverStripe\Forms\FieldList;
use SilverStripe\Core\Extension;

class ElementalUserFormsExtension extends Extension
{

    public function updateCMSFields(FieldList $fields)
    {
        $fields->removeByName('isFullWidth');
    }
}
