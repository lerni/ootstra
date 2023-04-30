<?php

namespace App\Extensions;

use SilverStripe\Core\Extension;
use SilverStripe\Forms\FieldList;

class ElementVirtualExtension extends Extension
{

    public function updateCMSFields(FieldList $fields)
    {
        $fields->removeByName([
            'Settings',
            'TitleLevel'
        ]);
    }
}
