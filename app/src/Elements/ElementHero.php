<?php

namespace App\Elements;

use DNADesign\Elemental\Models\BaseElement;
use App\Models\Slide;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldAddExistingAutocompleter;
use SilverStripe\Forms\GridField\GridFieldDetailForm;
use SilverStripe\Forms\GridField\GridFieldEditButton;
use SilverStripe\Forms\GridField\GridFieldConfig_Base;
use SilverStripe\Forms\GridField\GridFieldAddNewButton;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use SilverStripe\Forms\LiteralField;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;

class ElementHero extends BaseElement
{
    private static $db = [
        'Size' => 'Enum("small,medium,fullscreen","small")',
        'DoNotCrop' => 'Boolean'
    ];
    private static $many_many = [
        'Slides' => Slide::class
    ];
    private static $many_many_extraFields = [
        'Slides' => [
            'SortOrder' => 'Int'
        ]
    ];
    private static $owns = [
        'Slides'
    ];

    private static $table_name = 'ElementHero';

    private static $inline_editable = false;

    private static $icon = 'font-icon-block-carousel';

    private static $field_labels = [
        'Size' => 'Grösse/Höhe Header'
    ];

    private static $defaults = [
        'isFullWidth' => 1
    ];

    private static $description = 'Hero Element';

    public function getCMSFields()
    {

        $fields = parent::getCMSFields();
        $fields->removeByName('Slides');
        $fields->removeByName('AnchorLink');
        $fields->removeByName('BackgroundColor');

        if ($SizeField = $fields->dataFieldByName('Size')) {
            $fields->addFieldToTab('Root.Settings', $SizeField, 'isFullWidth');
            $SizeField->setDescription('"fullscreen" erfordert "volle Breite"!');
        }

        // hack arround unsaved relations
        if ($this->isInDB()) {
            $SlideGridFieldConfig = GridFieldConfig_Base::create(20);
            $SlideGridFieldConfig->addComponents(
                new GridFieldEditButton(),
                new GridFieldDeleteAction(false),
                new GridFieldDeleteAction(true),
                new GridFieldDetailForm(),
                new GridFieldAddNewButton('toolbar-header-right'),
                new GridFieldAddExistingAutocompleter('toolbar-header-right')
            );
            $SlideGridFieldConfig->addComponent(new GridFieldOrderableRows('SortOrder'));
            $gridField = new GridField('Slides', 'Slides', $this->owner->Slides(), $SlideGridFieldConfig);
            $fields->addFieldToTab('Root.Main', $gridField);
        } else {
            $fields->addFieldToTab("Root.Main", LiteralField::create('firstsave', '<p style="font-weight:bold; color:#555;">' . _t('SilverStripe\CMS\Controllers\CMSMain.SaveFirst', 'none') . '</p>'));
        }

        if ($DoNotCropField = $fields->dataFieldByName('DoNotCrop')) {
            // $DoNotCropField->setRightTitle('DoNotCrop');
            $DoNotCropField->setTitle('Höhe nicht begrenzen');
            $DoNotCropField->setDescription('Keine maximale Höhe in Grösse "medium"');
            $fields->addFieldToTab('Root.Settings', $DoNotCropField);
        }

        return $fields;
    }


    protected function provideBlockSchema()
    {
        $blockSchema = parent::provideBlockSchema();
        if ($this->Slides()->count() && $this->Slides()->Sort("SortOrder")->First()->SlideImage()->exists()) {
            $blockSchema['fileURL'] = $this->Slides()->Sort("SortOrder")->First()->SlideImage()->CMSThumbnail()->getURL();
        }
        return $blockSchema;
    }

    public function getType()
    {
        return _t(__CLASS__ . '.BlockType', 'false');
    }
}
