<?php

namespace App\Elements;

use App\Models\CountItem;
use App\Utility\GridFieldHelper;
use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\Forms\GridField\GridField;
use App\GridField\GridFieldConfig_SortableRelation;

class ElementCounter extends BaseElement
{
    private static $db = [];

    private static $many_many = [
        'CountItems' => CountItem::class,
    ];

    private static $many_many_extraFields = [
        'CountItems' => [
            'SortOrder' => 'Int',
        ],
    ];

    private static $table_name = 'ElementCounter';

    private static $field_labels = [];

    private static $class_description = 'Counter Element';

    private static $icon = 'font-icon-block-reports';

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->removeByName([
            'BackgroundColor',
            'CountItems',
        ]);

        GridFieldHelper::addIfSaved($fields, $this, fn () => GridField::create('CountBits', 'Graphs', $this->CountItems(), GridFieldConfig_SortableRelation::create('SortOrder')));

        return $fields;
    }

    public function getType()
    {
        return _t(self::class . '.BlockType', 'Counter');
    }
}
