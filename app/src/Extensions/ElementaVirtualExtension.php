<?php

namespace App\Extensions;

use SilverStripe\Core\Extension;
use SilverStripe\Forms\FieldList;

class ElementaVirtualExtension extends Extension
{

    public function updateCMSFields(FieldList $fields)
    {
        $fields->removeByName('Settings');
        $fields->removeByName('TitleLevel');
    }
}
