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

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->removeByName('ElementCounterID');
        return $fields;
    }
}
