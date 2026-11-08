<?php

namespace App\Elements;

use App\Models\Logo;
use App\Utility\GridFieldHelper;
use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\Forms\GridField\GridField;
use App\GridField\GridFieldConfig_SortableRelation;

class ElementLogo extends BaseElement
{
    private static $db = [
        'Greyscale' => 'Boolean',
        'Sorting' => 'Enum("random,manual","random")',
        'Layout' => 'Enum("block,slider", "block")',
    ];

    private static $has_one = [];

    private static $many_many = [
        'Logos' => Logo::class,
    ];

    private static $many_many_extraFields = [
        'Logos' => [
            'SortOrder' => 'Int',
        ],
    ];

    private static $owns = [
        'Logos',
    ];

    private static $table_name = 'ElementLogo';

    private static $class_description = 'Logo Element';

    private static $field_labels = [];

    private static $icon = 'font-icon-block-layout-2';

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->removeByName([
            'Logos',
        ]);

        if ($GreyscaleField = $fields->dataFieldByName('Greyscale')) {
            $fields->addFieldToTab('Root.Settings', $GreyscaleField);
        }

        GridFieldHelper::addIfSaved($fields, $this, fn () => GridField::create('Logos', 'Logos', $this->Logos(), GridFieldConfig_SortableRelation::create('SortOrder', 100)));

        return $fields;
    }

    public function Items()
    {
        if ($this->Logos()) {
            if ($this->Sorting == 'manual') {
                $items = $this->Logos()->sort('SortOrder ASC');
            } else {
                $items = $this->Logos()->shuffle();
            }

            return $items;
        }
    }

    protected function provideBlockSchema()
    {
        $blockSchema = parent::provideBlockSchema();
        if ($this->Logos()->count() && $this->Logos()->sort('SortOrder ASC')->first()->LogoImage()->exists()) {
            $blockSchema['fileURL'] = $this->Logos()->sort('SortOrder ASC')->first()->LogoImage()->CMSThumbnail()->getURL();
        }

        return $blockSchema;
    }

    public function getType()
    {
        return _t(self::class . '.BlockType', 'Logos (Partner)');
    }
}
