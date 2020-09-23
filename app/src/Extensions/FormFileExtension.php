<?php

namespace App\Extensions;

use SilverStripe\Core\Extension;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextareaField;

class FormFileExtension extends Extension
{
    public function updateFormFields(FieldList $fields)
    {
        $fields->insertAfter(
            'Title',
            TextareaField::create('Caption')
        );
    }
}
