<?php

namespace App\Extensions;

use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\DataExtension;

class ElementalUserFormsExtension extends DataExtension
{

    public function updateCMSFields(FieldList $fields)
    {
        $fields->removeByName("isFullWidth");
    }
}
