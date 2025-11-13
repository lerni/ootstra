<?php

namespace App\Elements;

use App\Models\Testimonial;
use App\Models\TestimonialCategory;
use SilverStripe\TagField\TagField;
use SilverStripe\Forms\LiteralField;
use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldDetailForm;
use SilverStripe\Forms\GridField\GridFieldEditButton;
use SilverStripe\Forms\GridField\GridFieldConfig_Base;
use SilverStripe\Forms\GridField\GridFieldAddNewButton;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use SilverStripe\Forms\GridField\GridFieldFilterHeader;

class ElementTestimonial extends BaseElement
{
    private static $db = [
        'CountMax' => 'Int',
        'Shuffle' => 'Boolean'
    ];

    private static $has_one = [];

    private static $has_many = [];

    private static $many_many = [
        // 'Categories' => TestimonialCategory::class . '.Elements' //1111
        'Categories' => TestimonialCategory::class //1111
    ];

    private static $defaults = [
        'SpacingTop' => 1,
        'SpacingBottom' => 1,
        'CountMax' => 5,
        'Shuffle' => 1
    ];

    private static $table_name = 'ElementTestimonial';

    private static $title = 'Testimonial Element';

    private static $icon = 'font-icon-block-conversation';

    public function fieldLabels($includerelations = true)
    {
        $labels = parent::fieldLabels($includerelations);
        $labels['CountMax'] = _t(__CLASS__ . '.COUNTMAX', 'Show maximum');
        $labels['Shuffle'] = _t(__CLASS__ . '.SHUFFLE', 'Random order');
        return $labels;
    }

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->removeByName([
            'Categories',
            'WidthReduced'
        ]);

        $CategoryField = TagField::create(
            'Categories',
            'Zeige Testimonials mit Kategorien...',
            TestimonialCategory::get(),
            $this->Categories()
        );

        $fields->addFieldToTab('Root.Main', $CategoryField);

        // Filter testimonials by selected categories
        $testimonials_selected = $this->getItems();
        if ($testimonials_selected->count()) {
            // hack around unsaved relations
            if ($this->isInDB()) {
                $TestimonialsSelectedGridFieldConfig = GridFieldConfig_Base::create(20);
                $TestimonialsSelectedGridFieldConfig->removeComponentsByType([
                    GridFieldFilterHeader::class
                ]);
                $gridField = new GridField('TestimonialsSelected', _t(__CLASS__ . '.TESTIMONIALSSELECTED', 'Testimonials (filtered by categories)'), $testimonials_selected, $TestimonialsSelectedGridFieldConfig);
                $fields->addFieldToTab('Root.Main', $gridField);
            } else {
                $fields->addFieldToTab('Root.Main', LiteralField::create('firstsave', '<p style="font-weight:bold; color:#555;">' . _t('SilverStripe\CMS\Controllers\CMSMain.SaveFirst', 'none') . '</p>'));
            }
        }

        if ($count_max_field = $fields->dataFieldByName('CountMax')) {
            $count_max_field->setDescription(_t(__CLASS__ . '.CountMaxFieldDescription', '"0" means no limit'));
        }

        $testimonials_all = Testimonial::get();
        // hack around unsaved relations
        if ($this->isInDB()) {
            $TestimonialsAllGridFieldConfig = GridFieldConfig_Base::create(20);
            $TestimonialsAllGridFieldConfig->removeComponentsByType([
                GridFieldFilterHeader::class
            ]);
            $TestimonialsAllGridFieldConfig->addComponents(
                new GridFieldEditButton(),
                new GridFieldDeleteAction(false),
                new GridFieldDetailForm(),
                new GridFieldAddNewButton('toolbar-header-right')
            );
            $gridField = new GridField('TestimonialsAll', _t(__CLASS__ . '.TESTIMONIALSALL', 'Testimonials (all)'), $testimonials_all, $TestimonialsAllGridFieldConfig);
            $fields->addFieldToTab('Root.Main', $gridField);
        } else {
            $fields->addFieldToTab('Root.Main', LiteralField::create('firstsave', '<p style="font-weight:bold; color:#555;">' . _t('SilverStripe\CMS\Controllers\CMSMain.SaveFirst', 'none') . '</p>'));
        }

        return $fields;
    }

    public function getItems()
    {
        $items = Testimonial::get();
        $categoriesIDs = $this->Categories()->column('ID');
        if (count($categoriesIDs)) {
            $items = $items->filter([
                'Categories.ID' => $categoriesIDs
            ]);
        }

        if ($this->Shuffle) {
            $items = $items->shuffle();
        }
        if ($this->CountMax) {
            $items = $items->limit($this->CountMax);
        }

        return $items;
    }

    public function getType()
    {
        return _t(__CLASS__ . '.BlockType', 'Testimonial');
    }
}
