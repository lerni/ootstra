<?php

namespace App\Elements;

use App\Models\Teaser;
use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldDetailForm;
use SilverStripe\Forms\GridField\GridFieldEditButton;
use SilverStripe\Forms\GridField\GridFieldConfig_Base;
use SilverStripe\Forms\GridField\GridFieldAddNewButton;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use SilverStripe\Forms\GridField\GridFieldAddExistingAutocompleter;
use SilverStripe\Forms\LiteralField;

class ElementTeaser extends BaseElement
{
    private static $db = [
        'Layout' => 'Enum("third,halve,full", "third")'
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

    private static $field_labels = [
        'Title' => 'Titel',
    ];

    private static $table_name = 'ElementTeaser';

    private static $title = 'Teaser Element';

    private static $icon = 'font-icon-block-layout-2';

    function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->removeByName([
            'BackgroundColor',
            'Teasers',
            'WidthReduced',
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
                new GridFieldAddNewButton('toolbar-header-right'),
                new GridFieldAddExistingAutocompleter('toolbar-header-right')
            );
            $TeaserGridFieldConfig->addComponent(new GridFieldOrderableRows('TeaserSortOrder'));
            $gridField = new GridField('Teasers', 'Teasers', $this->Teasers(), $TeaserGridFieldConfig);
            $fields->addFieldToTab('Root.Main', $gridField);
        } else {
            $fields->addFieldToTab('Root.Main', LiteralField::create('firstsave', '<p style="font-weight:bold; color:#555;">' . _t('SilverStripe\CMS\Controllers\CMSMain.SaveFirst', 'none') . '</p>'));
        }

        return $fields;
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
