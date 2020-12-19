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

    public function fieldLabels($includerelations = true)
    {
        $labels = parent::fieldLabels($includerelations);
        $labels['Title'] = _t(__CLASS__ . '.TITLE', 'Titel');

        return $labels;
    }

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
