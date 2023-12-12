<?php

namespace App\Extensions;

use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\DataExtension;

class BlogCategoryExtension extends DataExtension
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
