<?php

namespace App\Elements;

use App\Models\Perso;
use App\Models\Department;
use SilverStripe\Forms\LiteralField;
use App\Controller\ElementPersoController;
use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldDetailForm;
use SilverStripe\Forms\GridField\GridFieldEditButton;
use SilverStripe\Forms\GridField\GridFieldConfig_Base;
use SilverStripe\Forms\GridField\GridFieldAddNewButton;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use SilverStripe\Forms\GridField\GridFieldFilterHeader;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use SilverStripe\Forms\GridField\GridFieldAddExistingAutocompleter;

class ElementPerso extends BaseElement
{
    private static $db = [
        'Primary' => 'Boolean',
        'GroupByDepartment' => 'Boolean',
        'Sorting' => 'Enum("random,manual,alphabetically","random")',
    ];

    private static $has_one = [];

    private static $has_many = [];

    private static $many_many = [
        'Departments' => Department::class,
        'Persos' => Perso::class
    ];

    private static $many_many_extraFields = [
        'Departments' => [
            'DepartmentsSortOrder' => 'Int'
        ],
        'Persos' => [
            'PersosSortOrder' => 'Int'
        ]
    ];

    private static $owns = [
        'Departments'
    ];

    private static $defaults = [
        'AvailableGlobally' => false
    ];

    private static $table_name = 'ElementPerso';

    private static $field_labels = [];

    private static $class_description = 'Perso Element';

    private static $controller_class = ElementPersoController::class;

    private static $title = 'Personal';

    private static $singular_name = 'Personal';

    private static $plural_name = 'Personal';

    private static $icon = 'font-icon-block-group';

    public function fieldLabels($includerelations = true)
    {
        $labels = parent::fieldLabels($includerelations);
        $labels['GroupByDepartment'] = _t(__CLASS__ . '.GROUPBYDEPARTMENT', 'Group by department');
        return $labels;
    }

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->removeByName([
            'Persos',
            'isFullWidth',
            'Departments'
        ]);

        if ($AvailableGloballyField = $fields->dataFieldByName('AvailableGlobally')) {
            $AvailableGloballyField->setDisabled(true);
        }

        // hack around unsaved relations
        if ($this->isInDB()) {
            $DepGFConfig = GridFieldConfig_Base::create(20);
            $DepGFConfig->addComponents(
                new GridFieldEditButton(),
                new GridFieldDeleteAction(false),
                new GridFieldDetailForm(),
                new GridFieldAddNewButton('toolbar-header-left'),
                new GridFieldAddExistingAutocompleter('toolbar-header-right'),
                new GridFieldOrderableRows('DepartmentsSortOrder')
            );
            $DepGFConfig->removeComponentsByType(GridFieldFilterHeader::class);
            $GFDep = new GridField('Departments', 'Abteilungen', $this->Departments(), $DepGFConfig);
            $GFDep->setDescription('<p><strong>' . _t(__CLASS__ . '.CanDeleteExplanation', 'Only departments without people can be deleted!') . '</strong></p>');
            $fields->addFieldToTab('Root.Main', $GFDep);
        } else {
            $fields->addFieldToTab('Root.Main', LiteralField::create('firstsave', '<p style="font-weight:bold; color:#555;">' . _t('SilverStripe\CMS\Controllers\CMSMain.SaveFirst', 'none') . '</p>'));
        }

        // hack around unsaved relations
        if ($this->isInDB()) {
            $PersoGFConfig = GridFieldConfig_Base::create(100);
            $PersoGFConfig->addComponents(
                new GridFieldEditButton(),
                new GridFieldDeleteAction(false),
                new GridFieldDeleteAction(true),
                new GridFieldDetailForm(),
                new GridFieldAddNewButton('toolbar-header-left'),
                new GridFieldAddExistingAutocompleter('toolbar-header-right')
            );
            if ($this->Sorting == 'manual' && $this->GroupByDepartment == 0) {
                $PersoGFConfig->addComponent(new GridFieldOrderableRows('PersosSortOrder'));
            }
            $PersoGFConfig->removeComponentsByType(GridFieldFilterHeader::class);
            $GFPerso = new GridField('Persos', _t(__CLASS__ . '.PERSOS', 'Employees'), $this->Everybody(), $PersoGFConfig);
            $fields->addFieldToTab('Root.Main', $GFPerso);
        } else {
            $fields->addFieldToTab('Root.Main', LiteralField::create('firstsave', '<p style="font-weight:bold; color:#555;">' . _t('SilverStripe\CMS\Controllers\CMSMain.SaveFirst', 'none') . '</p>'));
        }

        if ($GroupByDepartmentField = $fields->dataFieldByName('GroupByDepartment')) {
            $GroupByDepartmentField->setDescription(_t(__CLASS__ . '.GroupByDepartmentDescription', 'If checked, adjust sorting in department'));
        }

        if (($SortingField = $fields->dataFieldByName('Sorting')) && $this->GroupByDepartment) {
            $SortingField->setDisabled(true);
        }

        if ($PrimaryField = $fields->dataFieldByName('Primary')) {
            if (!$this->Primary && $this->ClassName::get()->filter(['Primary' => 1])->count()) {
                $PrimaryPersoElement = $this->ClassName::get()->filter(['Primary' => 1])->first()->AbsoluteLink();
                $PrimaryField = LiteralField::create(
                    'PrimaryIs',
                    sprintf(
                        '<p class="alert alert-info">Primary Job Element is %s</p>',
                        $PrimaryPersoElement
                    )
                );
            }
            $fields->addFieldToTab('Root.Settings', $PrimaryField);
            $PrimaryField->setTitle('Primärers PersoElement (linked)');
        }

        return $fields;
    }

    public function Everybody()
    {
        $all = $this->Persos();
//         if ($this->Departments()->count() && $this->JustListedDepartments) {
//             $departmentIDs = $this->Departments()->column('ID');
//             // -> distinct() is a bitch
//             $all->filter('Departments.ID', $departmentIDs)
//                 ->alterDataQuery(function ($query) {
//                     $query->groupby('"Perso"."ID"');
//                 });
//         }
        if ($this->Sorting == 'random') {
            $all = $all->shuffle();
        }
        if ($this->Sorting == 'manual') {
            $all = $all->sort('PersosSortOrder ASC');
        }
        if ($this->Sorting == 'alphabetically') {
            $all = $all->sort(['Lastname' => 'ASC', 'Firstname' => 'ASC']);
        }
        return $all;
    }

    // first one should be primary unless selected differently
    public function onAfterPopulateDefaults()
    {
        $this->Primary = 1;
        if ($PersoElements = $this->ClassName::get()->filter('Primary', 1)->count()) {
            $this->Primary = 0;
        }
        parent::onAfterPopulateDefaults();
    }

    public function getType()
    {
        return _t(__CLASS__ . '.BlockType', 'Team');
    }
}
