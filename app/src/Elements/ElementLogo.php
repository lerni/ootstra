<?php

namespace App\Elements;

use App\Models\Logo;
use SilverStripe\Forms\LiteralField;
use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldDetailForm;
use SilverStripe\Forms\GridField\GridFieldEditButton;
use SilverStripe\Forms\GridField\GridFieldConfig_Base;
use SilverStripe\Forms\GridField\GridFieldAddNewButton;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;

class ElementLogo extends BaseElement
{
    private static $db = [
        'Greyscale' => 'Boolean'
    ];

    private static $has_one = [];

    private static $many_many = [
        'Logos' => Logo::class
    ];

    private static $many_many_extraFields = [
        'Logos' => [
            'SortOrder' => 'Int'
        ]
    ];

    private static $owns = [
        'Logos'
    ];

    private static $table_name = 'ElementLogo';

    private static $description = 'Logo Element';

    private static $field_labels = [];

    private static $icon = 'font-icon-block-layout-2';

    private static $inline_editable = false;

    function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->removeByName('Logos');

        if ($GreyscaleField = $fields->dataFieldByName('Greyscale')) {
            $fields->addFieldToTab('Root.Settings', $GreyscaleField);
        }

        // hack around unsaved relations
        if ($this->isInDB()) {
            $LogosGridFieldConfig = GridFieldConfig_Base::create(100);
            $LogosGridFieldConfig->addComponents(
                new GridFieldEditButton(),
                new GridFieldDeleteAction(false),
                // new GridFieldDeleteAction(true),
                new GridFieldDetailForm(),
                new GridFieldAddNewButton('toolbar-header-right'),
                new GridFieldOrderableRows('SortOrder')
                // new GridFieldAddExistingAutocompleter('toolbar-header-right')
            );
            $LogosGridFieldConfig->addComponent(new GridFieldOrderableRows('SortOrder'));
            $GridField = new GridField('Logos', 'Logos', $this->Logos(), $LogosGridFieldConfig);
            $fields->addFieldToTab('Root.Main', $GridField);
        } else {
            $fields->addFieldToTab('Root.Main', LiteralField::create('firstsave', '<p style="font-weight:bold; color:#555;">' . _t('SilverStripe\CMS\Controllers\CMSMain.SaveFirst', 'none') . '</p>'));
        }

        return $fields;
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
        return _t(__CLASS__ . '.BlockType', 'Logos (Partner)');
    }
}
