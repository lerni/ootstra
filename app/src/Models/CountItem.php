<?php

namespace App\Models;

use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\TextField;

class CountItem extends DataObject
{
    private static $db = [
        'Title' => 'Varchar',
        'Text' => 'Text',
        'Prefix' => 'Varchar',
        'Value' => 'Int',
        'Unit' => 'Varchar'
    ];

    private static $summary_fields = [
        'Title' => 'Title',
        'Value' => 'Wert'
    ];

    private static $table_name = 'CountItem';

    public function fieldLabels($includerelations = true)
    {
        $labels = parent::fieldLabels($includerelations);
        $labels['Value'] = _t(__CLASS__ . '.VALUE', 'Value');
        $labels['Title'] = _t(__CLASS__ . '.TITLE', 'Title');
        $labels['Prefix'] = _t(__CLASS__ . '.PREFIX', 'Prefix');
        $labels['Text'] = _t(__CLASS__ . '.TEXT', 'Text');
        $labels['Unit'] = _t(__CLASS__ . '.UNIT', 'Unit/Suffix');

        return $labels;
    }

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->removeByName([
            'ElementCounterID'
        ]);

        if ($valueFields = $fields->dataFieldByName('Value')) {
            // https://github.com/silverstripe/silverstripe-framework/issues/10626
            $stringField = TextField::create('Value', _t(__CLASS__ . '.VALUE', 'Value'));
            $fields->replaceField('Value', $stringField);
        }

        return $fields;
    }
}
