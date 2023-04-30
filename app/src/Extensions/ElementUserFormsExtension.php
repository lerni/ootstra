<?php

namespace App\Extensions;

use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\DataExtension;

class ElementUserFormsExtension extends DataExtension
{

    private static $defaults = [
        'AvailableGlobally' => 0
    ];

    public function updateCMSFields(FieldList $fields)
    {
        $fields->removeByName([
            'isFullWidth',
            'AvailableGlobally'
        ]);
    }
}
