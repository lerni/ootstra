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

        $fields->removeByName([
            'Feed & Share'
        ]);

        $fields->addFieldsToTab(
            'Root.Main',
            [
                FieldGroup::create(
                    _t('SilverStripe\CMS\Model\RedirectorPage.NEWWINDOW', 'target = "_blank"'),
                    CheckboxField::create('NewWindow', _t('SilverStripe\CMS\Model\RedirectorPage.NewWindowLabel', 'Open URL in a new window'))
                ),
            ]
        );
    }
}
