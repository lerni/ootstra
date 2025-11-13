<?php

namespace App\Models;

use App\Models\Perso;
use App\Elements\ElementPerso;
use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\View\Parsers\URLSegmentFilter;
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
        'Sort' => 'Int'
    ];

    private static $many_many = [
        'Persos' => Perso::class
    ];

    private static $many_many_extraFields = [
        'Persos' => [
            'SortOrder' => 'Int'
        ]
    ];

    private static $belongs_many_many = [
        'PersoElement' => ElementPerso::class
    ];

    private static $owns = [
        'Persos'
    ];

    private static $singular_name = 'department';
    private static $plural_name = 'departments';

    private static $default_sort = 'Sort ASC';

    private static $searchable_fields = ['Title'];

    private static $table_name = 'Department';

    private static $summary_fields = [
        'Title' => 'Titel',
        'DepartmentSize' => 'Anz. Mitarbeiter'
    ];

    public function fieldLabels($includerelations = true)
    {
        $labels = parent::fieldLabels($includerelations);
        $labels['Title'] = _t(__CLASS__ . '.TITLE', 'Titel');

        return $labels;
    }

    public function getCMSFields()
    {

        $fields = parent::getCMSFields();

        $fields->removeByName([
            'Sort',
            'Persos',
            'PersoElement'
        ]);

        // hack around unsaved relations
        if ($this->isInDB()) {
            $PersoGFConfig = GridFieldConfig_Base::create(100);
            $PersoGFConfig->addComponents(
                new GridFieldDeleteAction(true),
                new GridFieldAddExistingAutocompleter('toolbar-header-right'),
                new GridFieldOrderableRows('SortOrder')
            );
            $PersoGFConfig->removeComponentsByType(GridFieldFilterHeader::class);
            $GFPerso = new GridField('Persos', _t(__CLASS__ . '.PERSOS', 'Employees'), $this->Persos(), $PersoGFConfig);
            $fields->addFieldToTab('Root.Main', $GFPerso);
        } else {
            $fields->addFieldToTab('Root.Main', LiteralField::create('firstsave', '<p style="font-weight:bold; color:#555;">' . _t('SilverStripe\CMS\Controllers\CMSMain.SaveFirst', 'none') . '</p>'));
        }

        return $fields;
    }

    public function DepartmentSize() {
        return $this->Persos()->count();
    }

    public function canDelete($member = null)
    {
        // we return true, if the Department is not in use
        if ($this->Persos()->count() > 0) {
            return false;
        } else {
            return true;
        }
    }

    public function generateURLSegment()
    {
        $filter = new URLSegmentFilter();
        $this->URLSegment = $filter->filter($this->Title);
    }

    public function PersoString()
    {
        if ($this->Persos()->count()) {
            $dep = $this->Persos()->Sort('SortOrder ASC')->map()->toArray();
            $dep = implode(", ", $dep);
            return $dep;
        }
    }

    public function getCMSValidator()
    {
        return RequiredFieldsValidator::create([
            'Title'
        ]);
    }
}
