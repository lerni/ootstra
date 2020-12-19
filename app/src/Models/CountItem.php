<?php

namespace App\Models;

use SilverStripe\ORM\DataObject;

class CountItem extends DataObject
{
    private static $db = [
        'Title' => 'Varchar',
        'Text' => 'Text',
        'Value' => 'Int'
    ];

    private static $summary_fields = [
        'Title' => 'Title',
        'Value' => 'Wert'
    ];

    private static $table_name = 'CountItem';

    private static $field_labels = [
        'Value' => 'Wert',
        'Title' => 'Titel',
        'Text' => 'Text'
    ];

    public function fieldLabels($includerelations = true)
    {
        $labels = parent::fieldLabels($includerelations);
        $labels['Value'] = _t(__CLASS__ . '.VALUE', 'Wert');
        $labels['Title'] = _t(__CLASS__ . '.TITLE', 'Titel');
        $labels['Text'] = _t(__CLASS__ . '.TEXT', 'Text');

        return $labels;
    }

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->removeByName('ElementCounterID');
        return $fields;
    }
}
