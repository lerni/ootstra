<?php

namespace App\Extensions;

use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\FieldGroup;
use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\CheckboxField;

class RedirectorPageExtension extends DataExtension
{
    private static array $db = [
        'NewWindow' => 'Boolean',
    ];

    public function updateCMSFields(FieldList $fields): void
    {
        $fields->addFieldsToTab(
            'Root.Main',
            [
                FieldGroup::create(
                    'Open in new window',
                    CheckboxField::create('NewWindow', 'Check to open URL in a new window')
                ),
            ]
        );
    }
}
