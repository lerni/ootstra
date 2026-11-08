<?php

namespace App\Elements;

use App\Models\Teaser;
use App\Utility\GridFieldHelper;
use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\Forms\GridField\GridField;
use App\GridField\GridFieldConfig_SortableRelation;

class ElementTeaser extends BaseElement
{
    private static $db = [
        'Layout' => 'Enum("third,halve,full", "third")',
        'ShowAsSlider' => 'Boolean',
    ];

    private static $has_one = [];

    private static $has_many = [];

    private static $many_many = [
        'Teasers' => Teaser::class,
    ];

    private static $many_many_extraFields = [
        'Teasers' => [
            'TeaserSortOrder' => 'Int',
        ],
    ];

    private static $table_name = 'ElementTeaser';

    private static $title = 'Teaser Element';

    private static $icon = 'font-icon-block-layout-2';

    public function fieldLabels($includerelations = true)
    {
        $labels = parent::fieldLabels($includerelations);
        $labels['ShowAsSlider'] = _t(self::class . '.SHOWASSLIDER', 'Show as slider');

        return $labels;
    }

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->removeByName([
            'Teasers',
            'isFullWidth',
        ]);

        GridFieldHelper::addIfSaved($fields, $this, fn () => GridField::create('Teasers', 'Teasers', $this->Teasers(), GridFieldConfig_SortableRelation::create('TeaserSortOrder')));

        return $fields;
    }

    public function ChildTitleLevel()
    {
        $l = (int)$this->TitleLevel;
        ++$l;

        return 'h' . $l;
    }

    protected function provideBlockSchema()
    {
        $blockSchema = parent::provideBlockSchema();
        if ($this->Teasers()->count() && $this->Teasers()->sort('TeaserSortOrder ASC')->first()->Image()->exists()) {
            $blockSchema['fileURL'] = $this->Teasers()->sort('TeaserSortOrder ASC')->first()->Image()->CMSThumbnail()->getURL();
        }

        return $blockSchema;
    }

    public function getType()
    {
        return _t(self::class . '.BlockType', 'Teaser');
    }
}
