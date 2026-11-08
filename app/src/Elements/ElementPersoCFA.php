<?php

namespace App\Elements;

use App\Models\Perso;
use App\Utility\GridFieldHelper;
use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\Forms\GridField\GridField;
use App\GridField\GridFieldConfig_SortableRelation;

class ElementPersoCFA extends BaseElement
{
    private static $db = [
        'Above' => 'HTMLText',
        'CountMax' => 'Int',
        'Layout' => 'Enum("left,right", "right")',
        'Sorting' => 'Enum("random,manual","random")',
    ];

    private static $has_one = [];

    private static $has_many = [];

    private static $many_many = [
        'Persos' => Perso::class,
    ];

    private static $many_many_extraFields = [
        'Persos' => [
            'SortOrder' => 'Int',
        ],
    ];

    private static $owns = [
        'Persos',
    ];

    private static $table_name = 'ElementPersoCFA';

    private static $defaults = [
        'CountMax' => 3,
    ];

    private static $class_description = 'Call for Contact Perso-Element';

    private static $title = 'Contact';

    private static $singular_name = 'Contact';

    private static $plural_name = 'Contacts';

    private static $icon = 'font-icon-block-user';

    public function fieldLabels($includerelations = true)
    {
        $labels = parent::fieldLabels($includerelations);
        $labels['CountMax'] = _t(self::class . '.COUNTMAX', 'Number (default 3)');
        $labels['Layout'] = _t(self::class . '.LAYOUT', 'Alignment text');

        return $labels;
    }

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->removeByName([
            'isFullWidth',
            'Persos',
        ]);

        GridFieldHelper::addIfSaved($fields, $this, fn () => GridField::create(
            'Persos',
            _t(self::class . '.PERSOS', 'Employees'),
            $this->Persos(),
            GridFieldConfig_SortableRelation::create($this->Sorting == 'manual' ? 'SortOrder' : null, 30),
        ));

        return $fields;
    }

    public function Items()
    {
        $items = $this->Persos();
        $items = $this->Sorting == 'random' ? $items->shuffle() : $items->sort('SortOrder');
        if ($this->CountMax) {
            $items = $items->limit($this->CountMax);
        }

        return $items;
    }

    protected function provideBlockSchema()
    {
        $blockSchema = parent::provideBlockSchema();
        if ($this->Items()->count() && $this->Items()->first()->Portrait()->exists()) {
            $blockSchema['fileURL'] = $this->Items()->first()->Portrait()->CMSThumbnail()->getURL();
        }

        return $blockSchema;
    }

    public function getType()
    {
        return _t(self::class . '.BlockType', 'Contact (CFA)');
    }
}
