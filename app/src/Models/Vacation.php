<?php

namespace App\Models;

use App\Models\Location;
use SilverStripe\ORM\DataObject;
use SilverStripe\TagField\TagField;
use SilverStripe\Security\Permission;
use SilverStripe\ORM\FieldType\DBDate;
use SilverStripe\Security\PermissionProvider;
use SilverStripe\Core\Validation\ValidationResult;

class Vacation extends DataObject implements PermissionProvider
{
    private static $db = [
        'Title' => 'Varchar',
        'StartDate' => DBDate::class,
        'EndDate' => DBDate::class
    ];

    private static $summary_fields = [
        'Title' => 'Title',
        'StartDate' => 'Start Date',
        'EndDate' => 'End Date',
        'LocationsString' => 'Standorte'
    ];

    private static $has_one = [];

    private static $many_many = [
        'Locations' => Location::class
    ];

    private static $default_sort = 'StartDate ASC';

    private static $table_name = 'Vacation';

    public function providePermissions()
    {
        return [
            'VACATION_VIEW' => [
                'name' => 'View Vacations',
                'category' => 'Basket Orders',
                'help' => 'Allow viewing of vacations',
                'sort' => 100
            ],
            'VACATION_EDIT' => [
                'name' => 'Edit Vacations',
                'category' => 'Basket Orders',
                'help' => 'Allow editing of vacations',
                'sort' => 200
            ],
            'VACATION_DELETE' => [
                'name' => 'Delete Vacations',
                'category' => 'Basket Orders',
                'help' => 'Allow deletion of vacations',
                'sort' => 300
            ],
            'VACATION_CREATE' => [
                'name' => 'Create Vacations',
                'category' => 'Basket Orders',
                'help' => 'Allow creation of vacations',
                'sort' => 400
            ]
        ];
    }

    public function singular_name()
    {
        return _t(__CLASS__ . '.SINGULARNAME', 'Ferien');
    }

    public function plural_name()
    {
        return _t(__CLASS__ . '.PLURALNAME', 'Ferien');
    }

    public function fieldLabels($includerelations = true)
    {
        $labels = parent::fieldLabels($includerelations);
        $labels['Title'] = _t(__CLASS__ . '.TITLE', 'Title');
        $labels['StartDate'] = _t(__CLASS__ . '.STARTDATE', 'start date');
        $labels['EndDate'] = _t(__CLASS__ . '.ENDDATE', 'end date');
        return $labels;
    }

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->removeByName('Locations');
        $LocationsField = TagField::create(
            'Locations',
            _t('SilverStripe\Blog\Model\Blog.Departments',  _t(__CLASS__ . '.LOCATIONS', 'Locations')),
            Location::get(),
            $this->Locations()
        );
        $fields->addFieldToTab('Root.Main', $LocationsField);

        return $fields;
    }

    public function LocationsString() {
        return implode(', ', $this->Locations()->Column('Title'));
    }

    public function validate(): ValidationResult
    {
        $result = parent::validate();

        if (empty($this->Title)) {
            $result->addError(_t(__CLASS__ . '.TITLEVALIDATION', 'Titel ist ein Pflichtfeld.'));
        }

        if ($this->StartDate && $this->EndDate && $this->StartDate > $this->EndDate) {
            $result->addError(_t(__CLASS__ . '.DATEVALIDATION', 'Enddate must be after or on the same day as the start date.'));
        }

        if (!$this->Locations()->exists()) {
            $result->addError(_t(__CLASS__ . '.LOCATIONVALIDATION', 'One or more locations must be selected.'));
        }

        return $result;
    }

    public function canView($member = null)
    {
        return Permission::check('VACATION_VIEW', 'any', $member);
    }

    public function canEdit($member = null)
    {
        return Permission::check('VACATION_EDIT', 'any', $member);
    }

    public function canDelete($member = null)
    {
        return Permission::check('VACATION_DELETE', 'any', $member);
    }

    public function canCreate($member = null, $context = [])
    {
        return Permission::check('VACATION_CREATE', 'any', $member);
    }
}
