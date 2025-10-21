<?php

namespace App\Extensions;

use Page;
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

    public function canDelete($member = null)
    {
        // Check if any pages are using this category
        $pagesUsingCategory = Page::get()->filter([
            'PageCategories.ID' => $this->owner->ID
        ])->count();

        // Check if BlogCategory is on BlogPosts
        $postsUsingCategory = $this->owner->BlogPosts()->count();

        return ($pagesUsingCategory + $postsUsingCategory) <= 1;
    }
}
