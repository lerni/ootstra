<?php

namespace App\Elements;

use App\Models\Slide;
use SilverStripe\Forms\LiteralField;
use SilverStripe\SiteConfig\SiteConfig;
use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldDetailForm;
use SilverStripe\Forms\GridField\GridFieldEditButton;
use SilverStripe\Forms\GridField\GridFieldConfig_Base;
use SilverStripe\Forms\GridField\GridFieldAddNewButton;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use SilverStripe\Forms\GridField\GridFieldAddExistingAutocompleter;

class ElementHero extends BaseElement
{
    private static $db = [
        'HeroSize' => 'Enum("small,medium,fullscreen")',
        'DoNotCrop' => 'Boolean',
        'SitemapImageExpose' => 'Boolean',
        'CountMax' => 'Int',
        'Shuffle' => 'Boolean'
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

    // show available options in Slide & ElementHero
    public static $AvaliableHeroSizes = [
        'small' => 'small 4:1',
        'medium' => 'medium 2.215:1',
        'fullscreen' => 'fullscreen'
    ];

    private static $defaults = [
        'isFullWidth' => 1,
        'HeroSize' => 'medium', // todo: remove - but do we have defaults in SiteConfig ealy enough?
        'SitemapImageExpose' => 1
    ];

    public function populateDefaults()
    {
        $siteConfig = SiteConfig::current_site_config();
        if ($heroSize = $siteConfig->DefaultHeroSize) {
            $this->HeroSize = $heroSize;
        }
        parent::populateDefaults();
    }

    private static $description = 'Hero Element';

    private static $icon = 'font-icon-block-carousel';

    public function fieldLabels($includerelations = true)
    {
        $labels = parent::fieldLabels($includerelations);
        $labels['HeroSize'] = _t(__CLASS__ . '.HEROSIZE', 'Size / height header');
        $labels['DoNotCrop'] = _t(__CLASS__ . '.DONOTCROP', 'Do not limit height with wide viewport → "small" & "medium".');
        $labels['SitemapImageExpose'] = _t(__CLASS__ . '.SITEMAPIMAGEEXPOSE', 'expose images in sitemap.xml');
        $labels['CountMax'] = _t(__CLASS__ . '.TITLE', 'Zeige maximal');
        $labels['Shuffle'] = _t(__CLASS__ . '.TITLE', 'Reihenfolge zufällig');

        return $labels;
    }

    public function getCMSFields()
    {

        $fields = parent::getCMSFields();

        $fields->removeByName([
            'Slides',
            'AnchorLink'
        ]);

        if ($count_max_field = $fields->dataFieldByName('CountMax')) {
            $count_max_field->setDescription(_t(__CLASS__ . '.CountMaxFieldDescription', '"0" means no limit'));
        }

        if ($HeroSizeField = $fields->dataFieldByName('HeroSize')) {
            $fields->addFieldToTab('Root.Settings', $HeroSizeField, 'isFullWidth');
            $availableHeroAspectRatios = implode(', ', self::$AvaliableHeroSizes);
            $HeroSizeField->setDescription(_t(__CLASS__ . '.HeroSizeDescription', '{aspectRatios} - "fullscreen" requires "full width"!', ['aspectRatios' => $availableHeroAspectRatios]));
        }

        // hack around unsaved relations
        if ($this->isInDB()) {
            $SlideGridFieldConfig = GridFieldConfig_Base::create(20);
            $SlideGridFieldConfig->addComponents(
                new GridFieldEditButton(),
                new GridFieldDeleteAction(false),
                new GridFieldDeleteAction(true),
                new GridFieldDetailForm(),
                new GridFieldAddNewButton('toolbar-header-left'),
                new GridFieldAddExistingAutocompleter('toolbar-header-right')
            );
            $SlideGridFieldConfig->addComponent(new GridFieldOrderableRows('SortOrder'));
            $gridField = new GridField('Slides', 'Slides', $this->owner->Slides(), $SlideGridFieldConfig);
            $fields->addFieldToTab('Root.Main', $gridField);
        } else {
            $fields->addFieldToTab('Root.Main', LiteralField::create('firstsave', '<p style="font-weight:bold; color:#555;">' . _t('SilverStripe\CMS\Controllers\CMSMain.SaveFirst', 'none') . '</p>'));
        }

        if ($DoNotCropField = $fields->dataFieldByName('DoNotCrop')) {
            $DoNotCropField->setDescription(_t(__CLASS__ . '.DoNotCropDescription', 'No maximum height for "small" and "medium" size.'));
            $fields->addFieldToTab('Root.Settings', $DoNotCropField);
        }

        return $fields;
    }

    public function getItems()
    {
        $items = $this->Slides()->sort('SortOrder ASC');
        if ($this->Shuffle) {
            $items = $items->shuffle();
        }
        if ($this->CountMax) {
            $items = $items->limit($this->CountMax);
        }

        return $items;
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
        return _t(__CLASS__ . '.BlockType', 'Hero');
    }
}
