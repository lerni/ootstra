<?php

namespace App\Extensions;

use SilverStripe\Forms\FieldList;
use SilverStripe\Core\Extension;

class ElementContentExtension extends Extension
{

    private static $db = [];

    private static $inline_editable = false;

    private static $defaults = [
        'WidthReduced' => 1
    ];

    public function updateCMSFields(FieldList $fields)
    {

        $fields->removeByName('isFullWidth');

        if ($TextEditor = $fields->dataFieldByName('HTML')) {
            $TextEditor->setRows(30);
            $TextEditor->setAttribute('data-mce-body-class', $this->owner->ShortClassName('true'));
        }
    }
}
