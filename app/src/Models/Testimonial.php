<?php

namespace App\Models;


use SilverStripe\ORM\DataObject;
use App\Models\TestimonialCategory;
use SilverStripe\TagField\TagField;
use App\Elements\ElementTestimonial;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\Versioned\GridFieldArchiveAction;
use SilverStripe\Forms\GridField\GridFieldDataColumns;
use SilverStripe\Forms\GridField\GridFieldAddNewButton;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use SilverStripe\Forms\GridField\GridFieldSortableHeader;
use SilverStripe\Forms\GridField\GridFieldAddExistingAutocompleter;

class Testimonial extends DataObject
{
    private static $db = [
        'Title' => 'Text',
        'Text' => 'Text'
    ];


    private static $many_many = [
        // 'Categories' => TestimonialCategory::class . '.Testimonials' // 2222
        'Categories' => TestimonialCategory::class
    ];

    private static $singular_name = 'Testimonial';
    private static $plural_name = 'Testimonials';

    private static $table_name = 'Testimonial';

    private static $summary_fields = [
        'Title' => 'Name',
        'CategoriesAsString' => 'Categories'
    ];

    private static $indexes = [
        'Title' => [
            'type' => 'unique',
            'columns' => ['Title']
        ]
    ];

    public function fieldLabels($includerelations = true)
    {
        $labels = parent::fieldLabels($includerelations);
        $labels['Title'] = _t(__CLASS__ . '.TITLE', 'Name');
        return $labels;
    }

    public function getCMSFields()
    {

        $fields = parent::getCMSFields();

        $fields->removeByName([
            'Categories'
        ]);

        if ($TitleField = $fields->dataFieldByName('Title')) {
            $TitleField->setRows(1);
            $fields->insertAfter('Text', $TitleField);
        }


        $tagFiled = TagField::create(
            'Categories',
            _t('SilverStripe\Blog\Model\Blog.Categories', 'Categories'),
            TestimonialCategory::get(),
            $this->Categories()
        )->setShouldLazyLoad(true);

        $tagFiled->setDescription(_t('SilverStripe\Forms\GridField\GridField.PlaceHolderWithLabels', 'Tippe "%" um alle Datensätze anzuzeigen.'));
        $tagFiled->setCanCreate(true);
        $fields->addFieldToTab('Root.Main', $tagFiled);

        // if ($this->isInDB() && $this->ElementTestimonials()->count() > 1) {
        //     $fields
        //         ->fieldByName('Root.ElementTestimonials.ElementTestimonials')
        //         ->getConfig()
        //         ->removeComponentsByType([
        //             GridFieldAddNewButton::class,
        //             GridFieldArchiveAction::class,
        //             GridFieldDeleteAction::class,
        //             GridFieldAddExistingAutocompleter::class,
        //             GridFieldSortableHeader::class
        //         ]);

        //     $fields->fieldByName('Root.ElementTestimonials.ElementTestimonials')->setTitle(_t(__CLASS__ . '.IsUsedOnComment', 'This Testimonial is used on following Elements'));

        //     $fields
        //         ->fieldByName('Root.ElementTestimonials.ElementTestimonials')
        //         ->getConfig()
        //         ->getComponentByType(GridFieldDataColumns::class)
        //         ->setDisplayFields([
        //             'getTypeBreadcrumb' => 'Element'
        //         ]);

        //     $usedGF = $fields->fieldByName('Root.ElementTestimonials.ElementTestimonials');
        //     $fields->removeByName(['ElementTestimonials']);
        //     $fields->addFieldsToTab('Root.Main', $usedGF);
        // } else {
        //     $fields->removeByName(['Main.ElementTestimonials']);
        // }

        return $fields;
    }

    public function CategoriesAsString()
    {
        $categories = $this->Categories();
        if ($categories->exists()) {
            return implode(', ', $categories->column('Title'));
        }
        return '';
    }

    public function getCMSValidator()
    {
        return new RequiredFields([
            'Title'
        ]);
    }


    public function validate()
    {
        $result = parent::validate();

        if (static::get()->filter('Title', $this->Title)->exclude('ID', $this->ID)->count() > 0) {
            $result->addError(_t(__CLASS__ . '.Duplicate', '{FieldName} must be unique', ['FieldName' => 'Title']));
        }

        return $result;
    }
}

