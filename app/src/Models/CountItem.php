<?php

namespace App\Models;

use SilverStripe\ORM\DataObject;

class CountItem extends DataObject
{
    private static $db = [
        'Title' => 'Varchar',
        'Text' => 'Text',
        'Prefix' => 'Varchar',
        'Value' => 'Int',
        'Unit' => 'Varchar',
    ];

    private static $summary_fields = [
        'Title' => 'Title',
        'Value' => 'Wert',
    ];

    private static $table_name = 'CountItem';

    public function fieldLabels($includerelations = true)
    {
        $labels = parent::fieldLabels($includerelations);
        $labels['Value'] = _t(self::class . '.VALUE', 'Value');
        $labels['Title'] = _t(self::class . '.TITLE', 'Title');
        $labels['Prefix'] = _t(self::class . '.PREFIX', 'Prefix');
        $labels['Text'] = _t(self::class . '.TEXT', 'Text');
        $labels['Unit'] = _t(self::class . '.UNIT', 'Unit/Suffix');

        return $labels;
    }

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->removeByName([
            'ElementCounterID',
        ]);

        return $fields;
    }
}
