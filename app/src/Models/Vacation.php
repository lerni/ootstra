<?php

namespace App\Models;

use SilverStripe\ORM\DataObject;
use SilverStripe\Security\Permission;
use SilverStripe\ORM\FieldType\DBDate;
use SilverStripe\Security\PermissionProvider;
use SilverStripe\Core\Validation\ValidationResult;

class Vacation extends DataObject implements PermissionProvider
{
    private static $db = [
        'Title' => 'Varchar',
        'StartDate' => DBDate::class,
        'EndDate' => DBDate::class,
    ];

    private static $summary_fields = [
        'Title' => 'Title',
        'StartDate' => 'Start Date',
        'EndDate' => 'End Date',
    ];

    private static $default_sort = 'StartDate ASC';

    private static $table_name = 'Vacation';

    public function providePermissions()
    {
        return [
            'VACATION_VIEW' => [
                'name' => 'View Vacations',
                'category' => _t(self::class . '.PERMISSIONCATEGORY', 'Vacations'),
                'help' => 'Allow viewing of vacations',
                'sort' => 100,
            ],
            'VACATION_EDIT' => [
                'name' => 'Edit Vacations',
                'category' => _t(self::class . '.PERMISSIONCATEGORY', 'Vacations'),
                'help' => 'Allow editing of vacations',
                'sort' => 200,
            ],
            'VACATION_DELETE' => [
                'name' => 'Delete Vacations',
                'category' => _t(self::class . '.PERMISSIONCATEGORY', 'Vacations'),
                'help' => 'Allow deletion of vacations',
                'sort' => 300,
            ],
            'VACATION_CREATE' => [
                'name' => 'Create Vacations',
                'category' => _t(self::class . '.PERMISSIONCATEGORY', 'Vacations'),
                'help' => 'Allow creation of vacations',
                'sort' => 400,
            ],
        ];
    }

    public function singular_name()
    {
        return _t(self::class . '.SINGULARNAME', 'Ferien');
    }

    public function plural_name()
    {
        return _t(self::class . '.PLURALNAME', 'Ferien');
    }

    public function fieldLabels($includerelations = true)
    {
        $labels = parent::fieldLabels($includerelations);
        $labels['Title'] = _t(self::class . '.TITLE', 'Title');
        $labels['StartDate'] = _t(self::class . '.STARTDATE', 'start date');
        $labels['EndDate'] = _t(self::class . '.ENDDATE', 'end date');

        return $labels;
    }

    public function validate(): ValidationResult
    {
        $result = parent::validate();

        if (empty($this->Title)) {
            $result->addError(_t(self::class . '.TITLEVALIDATION', 'Titel ist ein Pflichtfeld.'));
        }

        if ($this->StartDate && $this->EndDate && $this->StartDate > $this->EndDate) {
            $result->addError(_t(self::class . '.DATEVALIDATION', 'Enddate must be after or on the same day as the start date.'));
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
