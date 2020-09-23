<?php

namespace App\Extensions;

use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\DataExtension;

class ElementContentExtension extends DataExtension
{

    private static $db = [];

    private static $inline_editable = false;

    public function updateCMSFields(FieldList $fields)
    {

        $fields->removeByName('isFullWidth');

        if ($TextEditor = $fields->dataFieldByName('HTML')) {
            $TextEditor->setRows(40);
            $TextEditor->addExtraClass('stacked');
            $TextEditor->setAttribute('data-mce-body-class', $this->owner->ShortClassName('true'));
        }
    }
}
