<?php

namespace App\Elements;

use App\Models\Slide;
use App\Utility\GridFieldHelper;
use SilverStripe\SiteConfig\SiteConfig;
use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\Forms\GridField\GridField;
use App\GridField\GridFieldConfig_SortableRelation;

class ElementHero extends BaseElement
{
    private static $db = [
        'HeroSize' => 'Enum("small,medium,fullscreen")',
        'DoNotCrop' => 'Boolean',
        'SitemapImageExpose' => 'Boolean',
        'CountMax' => 'Int',
        'Shuffle' => 'Boolean',
    ];

    private static $many_many = [
        'Slides' => Slide::class,
    ];

    private static $many_many_extraFields = [
        'Slides' => [
            'SortOrder' => 'Int',
        ],
    ];

    private static $owns = [
        'Slides',
    ];

    private static $table_name = 'ElementHero';

    // show available options in Slide & ElementHero
    public static $AvaliableHeroSizes = [
        'small' => 'small 4:1',
        'medium' => 'medium 2.215:1',
        'fullscreen' => 'fullscreen',
    ];

    private static $defaults = [
        'isFullWidth' => true,
        'HeroSize' => 'medium', // todo: remove - but do we have defaults in SiteConfig ealy enough?
        'SitemapImageExpose' => true,
    ];

    public function onAfterPopulateDefaults()
    {
        $siteConfig = SiteConfig::current_site_config();
        if ($heroSize = $siteConfig->DefaultHeroSize) {
            $this->HeroSize = $heroSize;
        }
        parent::onAfterPopulateDefaults();
    }

    private static $class_description = 'Hero Element';

    private static $icon = 'font-icon-block-carousel';

    public function fieldLabels($includerelations = true)
    {
        $labels = parent::fieldLabels($includerelations);
        $labels['HeroSize'] = _t(self::class . '.HEROSIZE', 'Size / height header');
        $labels['DoNotCrop'] = _t(self::class . '.DONOTCROP', 'Do not limit height with wide viewport → "small" & "medium".');
        $labels['SitemapImageExpose'] = _t(self::class . '.SITEMAPIMAGEEXPOSE', 'expose images in sitemap.xml');
        $labels['CountMax'] = _t(self::class . '.COUNTMAX', 'Show maximum');
        $labels['Shuffle'] = _t(self::class . '.SHUFFLE', 'Random order');

        return $labels;
    }

    public function getCMSFields()
    {

        $fields = parent::getCMSFields();

        $fields->removeByName([
            'Slides',
            'AnchorLink',
        ]);

        if ($count_max_field = $fields->dataFieldByName('CountMax')) {
            $count_max_field->setDescription(_t(self::class . '.CountMaxFieldDescription', '"0" means no limit'));
        }

        if ($HeroSizeField = $fields->dataFieldByName('HeroSize')) {
            $fields->addFieldToTab('Root.Settings', $HeroSizeField, 'isFullWidth');
            $availableHeroAspectRatios = implode(', ', self::$AvaliableHeroSizes);
            $HeroSizeField->setDescription(_t(self::class . '.HeroSizeDescription', '{aspectRatios} - "fullscreen" requires "full width"!', ['aspectRatios' => $availableHeroAspectRatios]));
        }

        GridFieldHelper::addIfSaved($fields, $this, fn () => GridField::create('Slides', 'Slides', $this->Slides(), GridFieldConfig_SortableRelation::create('SortOrder')));

        if ($DoNotCropField = $fields->dataFieldByName('DoNotCrop')) {
            $DoNotCropField->setDescription(_t(self::class . '.DoNotCropDescription', 'No maximum height for "small" and "medium" size.'));
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
        $firstSlide = $this->Slides()->Sort("SortOrder")->first();
        if ($firstSlide && $firstSlide->SlideImage()->exists()) {
            $blockSchema['fileURL'] = $firstSlide->SlideImage()->CMSThumbnail()->getURL();
        }

        return $blockSchema;
    }

    public function getType()
    {
        return _t(self::class . '.BlockType', 'Hero');
    }
}
