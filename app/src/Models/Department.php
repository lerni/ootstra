<?php

namespace App\Models;

use App\Models\Perso;
use App\Elements\ElementPerso;
use App\Utility\GridFieldHelper;
use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\View\Parsers\URLSegmentFilter;
use SilverStripe\Forms\Validation\CompositeValidator;
use SilverStripe\Forms\GridField\GridFieldConfig_Base;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use SilverStripe\Forms\GridField\GridFieldFilterHeader;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use SilverStripe\Forms\Validation\RequiredFieldsValidator;
use SilverStripe\Forms\GridField\GridFieldAddExistingAutocompleter;

class Department extends DataObject
{
    private static $db = [
        'Title' => 'Varchar',
        'Sort' => 'Int',
    ];

    private static $many_many = [
        'Persos' => Perso::class,
    ];

    private static $many_many_extraFields = [
        'Persos' => [
            'SortOrder' => 'Int',
        ],
    ];

    private static $belongs_many_many = [
        'PersoElement' => ElementPerso::class,
    ];

    private static $owns = [
        'Persos',
    ];

    private static $singular_name = 'department';

    private static $plural_name = 'departments';

    private static $default_sort = 'Sort ASC';

    private static $searchable_fields = ['Title'];

    private static $table_name = 'Department';

    private static $summary_fields = [
        'Title' => 'Titel',
        'DepartmentSize' => 'Anz. Mitarbeiter',
    ];

    public function fieldLabels($includerelations = true)
    {
        $labels = parent::fieldLabels($includerelations);
        $labels['Title'] = _t(self::class . '.TITLE', 'Titel');

        return $labels;
    }

    public function getCMSFields()
    {

        $fields = parent::getCMSFields();

        $fields->removeByName([
            'Sort',
            'Persos',
            'PersoElement',
        ]);

        GridFieldHelper::addIfSaved($fields, $this, function () {
            $PersoGFConfig = GridFieldConfig_Base::create(100);
            $PersoGFConfig->addComponents(
                GridFieldDeleteAction::create(true),
                GridFieldAddExistingAutocompleter::create('toolbar-header-right'),
                GridFieldOrderableRows::create('SortOrder'),
            );
            $PersoGFConfig->removeComponentsByType(GridFieldFilterHeader::class);

            return GridField::create('Persos', _t(self::class . '.PERSOS', 'Employees'), $this->Persos(), $PersoGFConfig);
        });

        return $fields;
    }

    public function DepartmentSize()
    {
        return $this->Persos()->count();
    }

    public function canDelete($member = null)
    {
        // we return true, if the Department is not in use
        return $this->Persos()->count() <= 0;
    }

    public function generateURLSegment()
    {
        $filter = URLSegmentFilter::create();
        $this->URLSegment = $filter->filter($this->Title);
    }

    public function PersoString()
    {
        if ($this->Persos()->count()) {
            $dep = $this->Persos()->sort('SortOrder ASC')->map()->toArray();

            return implode(", ", $dep);
        }

        return null;
    }

    public function getCMSCompositeValidator(): CompositeValidator
    {
        $validator = parent::getCMSCompositeValidator();
        $validator->addValidator(
            RequiredFieldsValidator::create([
                'Title',
            ]),
        );

        return $validator;
    }
}
