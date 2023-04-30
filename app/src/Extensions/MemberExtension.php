<?php

namespace App\Extensions;

use SilverStripe\Forms\FieldList;
use SilverStripe\Core\Extension;
use SilverStripe\Security\Permission;

class MemberExtension extends Extension
{
    public function updateCMSFields(FieldList $fields)
    {
        if (!Permission::check('ADMIN')) {
            $fields->removeByName([
                'FailedLoginCount',
                'Locale'
            ]);
        }
        $fields->removeByName([
            'BlogProfileSummary',
            'BlogProfileImage',
            'Root.BlogPosts',
            'BlogPosts'
        ]);
    }
}
