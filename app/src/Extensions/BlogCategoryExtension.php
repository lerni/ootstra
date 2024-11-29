<?php

namespace App\Extensions;

use SilverStripe\Core\Extension;
use SilverStripe\Forms\FieldList;

class BlogCategoryExtension extends Extension
{
    private static $db = [
        'SortOrder' => 'Int'
    ];

    private static $default_sort = 'SortOrder ASC';

    public function updateCMSFields(FieldList $fields) {

        $fields->removeByName([
            'SortOrder'
        ]);

        return $fields;
    }
}
