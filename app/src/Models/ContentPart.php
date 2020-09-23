<?php

namespace App\Models;

use SilverStripe\ORM\DataObject;
use App\Elements\ElementContentSection;

class ContentPart extends DataObject
{
    private static $db = [
        'Title' => 'Varchar',
        'Text' => 'HTMLText'
    ];

    private static $casting = [
        'Text' => 'HTMLText'
    ];

    private static $summary_fields = [
        'Title' => 'Title',
        'Text.Summary' => 'Text'
    ];

    private static $field_labels = [
        'Title' => 'Titel'
    ];

    private static $table_name = 'ContentPart';

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        if ($TextEditorField = $fields->dataFieldByName('Text')) {
            $TextEditorField->setRows(30);
            $TextEditorField->addExtraClass('stacked');
        }

        return $fields;
    }
}
