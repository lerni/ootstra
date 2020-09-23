<?php

namespace App\Extensions;

use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\DataExtension;
use SilverStripe\Security\Permission;

class MemberExtension extends DataExtension
{
    public function updateCMSFields(FieldList $fields)
    {
        if (!Permission::check('ADMIN')) {
            $fields->removeByName('FailedLoginCount');
            $fields->removeByName('Locale');
        }
        $fields->removeByName('BlogProfileSummary');
        $fields->removeByName('BlogProfileImage');
        $fields->removeByName('Root.BlogPosts');
        $fields->removeByName('BlogPosts');
    }
}
