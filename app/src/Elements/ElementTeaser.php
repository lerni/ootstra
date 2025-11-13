<?php

namespace App\Elements;

use App\Models\Teaser;
use SilverStripe\Forms\LiteralField;
use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldDetailForm;
use SilverStripe\Forms\GridField\GridFieldEditButton;
use SilverStripe\Forms\GridField\GridFieldConfig_Base;
use SilverStripe\Forms\GridField\GridFieldAddNewButton;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use SilverStripe\Forms\GridField\GridFieldFilterHeader;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use SilverStripe\Forms\GridField\GridFieldAddExistingAutocompleter;

class ElementTeaser extends BaseElement
{
    private static $db = [
        'Layout' => 'Enum("third,halve,full", "third")',
        'ShowAsSlider' => 'Boolean'
    ];

    private static $has_one = [];

    private static $has_many = [];

    private static $many_many = [
        'Teasers' => Teaser::class
    ];

    private static $many_many_extraFields = [
        'Teasers' => [
            'TeaserSortOrder' => 'Int'
        ]
    ];

    private static $table_name = 'ElementTeaser';

    private static $title = 'Teaser Element';

    private static $icon = 'font-icon-block-layout-2';

    public function fieldLabels($includerelations = true)
    {
        $labels = parent::fieldLabels($includerelations);
        $labels['ShowAsSlider'] = _t(__CLASS__ . '.SHOWASSLIDER', 'Show as slider');
        return $labels;
    }

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->removeByName([
            'Teasers',
            'isFullWidth'
        ]);

        // hack around unsaved relations
        if ($this->isInDB()) {
            $TeaserGridFieldConfig = GridFieldConfig_Base::create(20);
            $TeaserGridFieldConfig->addComponents(
                new GridFieldEditButton(),
                new GridFieldDeleteAction(false),
                new GridFieldDeleteAction(true),
                new GridFieldDetailForm(),
                new GridFieldAddNewButton('toolbar-header-left'),
                new GridFieldAddExistingAutocompleter('toolbar-header-right'),
                new GridFieldOrderableRows('TeaserSortOrder')
            );
            $TeaserGridFieldConfig->removeComponentsByType(GridFieldFilterHeader::class);
            $gridField = new GridField('Teasers', 'Teasers', $this->Teasers(), $TeaserGridFieldConfig);
            $fields->addFieldToTab('Root.Main', $gridField);
        } else {
            $fields->addFieldToTab('Root.Main', LiteralField::create('firstsave', '<p style="font-weight:bold; color:#555;">' . _t('SilverStripe\CMS\Controllers\CMSMain.SaveFirst', 'none') . '</p>'));
        }

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
        return _t(__CLASS__ . '.BlockType', 'Teaser');
    }
}
