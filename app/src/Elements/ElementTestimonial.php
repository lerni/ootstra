<?php

namespace App\Elements;

use App\Models\Testimonial;
use App\Utility\GridFieldHelper;
use App\Models\TestimonialCategory;
use SilverStripe\TagField\TagField;
use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\Forms\GridField\GridField;
use App\GridField\GridFieldConfig_OwnRecords;
use SilverStripe\Forms\GridField\GridFieldConfig_Base;
use SilverStripe\Forms\GridField\GridFieldFilterHeader;

class ElementTestimonial extends BaseElement
{
    private static $db = [
        'CountMax' => 'Int',
        'Shuffle' => 'Boolean',
    ];

    private static $has_one = [];

    private static $has_many = [];

    private static $many_many = [
        // 'Categories' => TestimonialCategory::class . '.Elements' //1111
        'Categories' => TestimonialCategory::class, //1111
    ];

    private static $defaults = [
        'SpacingTop' => 1,
        'SpacingBottom' => 1,
        'CountMax' => 5,
        'Shuffle' => true,
    ];

    private static $table_name = 'ElementTestimonial';

    private static $title = 'Testimonial Element';

    private static $icon = 'font-icon-block-conversation';

    public function fieldLabels($includerelations = true)
    {
        $labels = parent::fieldLabels($includerelations);
        $labels['CountMax'] = _t(self::class . '.COUNTMAX', 'Show maximum');
        $labels['Shuffle'] = _t(self::class . '.SHUFFLE', 'Random order');

        return $labels;
    }

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->removeByName([
            'Categories',
            'WidthReduced',
        ]);

        $CategoryField = TagField::create(
            'Categories',
            'Zeige Testimonials mit Kategorien...',
            TestimonialCategory::get(),
            $this->Categories(),
        );

        $fields->addFieldToTab('Root.Main', $CategoryField);

        // Filter testimonials by selected categories
        $testimonials_selected = $this->getItems();
        if ($testimonials_selected->count()) {
            GridFieldHelper::addIfSaved($fields, $this, fn () => GridField::create(
                'TestimonialsSelected',
                _t(self::class . '.TESTIMONIALSSELECTED', 'Testimonials (filtered by categories)'),
                $testimonials_selected,
                GridFieldConfig_Base::create(20)->removeComponentsByType(GridFieldFilterHeader::class),
            ));
        }

        if ($count_max_field = $fields->dataFieldByName('CountMax')) {
            $count_max_field->setDescription(_t(self::class . '.CountMaxFieldDescription', '"0" means no limit'));
        }

        $testimonials_all = Testimonial::get();
        GridFieldHelper::addIfSaved($fields, $this, fn () => GridField::create('TestimonialsAll', _t(self::class . '.TESTIMONIALSALL', 'Testimonials (all)'), $testimonials_all, GridFieldConfig_OwnRecords::create()));

        return $fields;
    }

    public function getItems()
    {
        $items = Testimonial::get();
        $categoriesIDs = $this->Categories()->column('ID');
        if (count($categoriesIDs)) {
            $items = $items->filter([
                'Categories.ID' => $categoriesIDs,
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
        return _t(self::class . '.BlockType', 'Testimonial');
    }
}
