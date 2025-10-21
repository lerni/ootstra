<?php

namespace App\Extensions;

use SilverStripe\Core\Extension;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\FieldGroup;
use SilverStripe\Forms\CheckboxField;

class RedirectorPageExtension extends Extension
{
    private static array $db = [
        'NewWindow' => 'Boolean',
    ];

    public function updateCMSFields(FieldList $fields): void
    {

        $fields->removeByName([
            'Feed & Share',
            'Title',
            'CanonicalURL',
            'PageCategories',
            'PinterestImageCustom'
        ]);

        $fields->replaceField(
            'NewWindow',
            FieldGroup::create(
                _t('SilverStripe\CMS\Model\RedirectorPage.NEWWINDOW', 'target = "_blank"'),
                CheckboxField::create('NewWindow', _t('SilverStripe\CMS\Model\RedirectorPage.NewWindowLabel', 'Open URL in a new window'))
            )
        );
    }
}
