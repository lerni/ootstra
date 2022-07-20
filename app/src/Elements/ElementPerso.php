<?php

namespace App\Elements;

use App\Models\Perso;
use App\Models\Department;
use SilverStripe\Forms\LiteralField;
use App\Controller\ElementPersoController;
use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldAddNewButton;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
use SilverStripe\Forms\GridField\GridFieldAddExistingAutocompleter;


class ElementPerso extends BaseElement
{
    private static $db = [
        'Primary' => 'Boolean',
        'Sorting' => 'Enum("random,manual","random")',
    ];

    private static $has_one = [];

    private static $has_many = [];

    private static $many_many = [
        'Departments' => Department::class
    ];

    // static $many_many_extraFields = [
    // 	'Departments' => [
    // 		'SortOrder' => 'Int'
    // 	]
    // ];

    private static $owns = [
        'Departments'
    ];

    private static $table_name = 'ElementPerso';

    private static $field_labels = [];

    private static $description = 'Perso Element';

    private static $controller_class = ElementPersoController::class;

    private static $title = 'Personal';

    private static $singular_name = 'Personal';

    private static $plural_name = 'Personal';

    private static $icon = 'font-icon-block-group';

    private static $inline_editable = false;

    function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->removeByName([
            'Persos',
            'isFullWidth',
            'Departments'
        ]);

        $DepGFConfig = GridFieldConfig_RecordEditor::create(20);
        $DepGFConfig->removeComponentsByType('SilverStripe\Forms\GridField\GridFieldPageCount');
        $DepGFConfig->removeComponentsByType('SilverStripe\Forms\GridField\GridFieldAddNewButton');

        // hack around unsaved relations
        if ($this->isInDB()) {
            $DepGFConfig->addComponents(
                new GridFieldDeleteAction(true),
                new GridFieldAddExistingAutocompleter('toolbar-header-right'),
                new GridFieldAddNewButton('toolbar-header-right')
            );
            $DepGFConfig->addComponent(new GridFieldOrderableRows('Sort'));
        } else {
            $fields->addFieldToTab('Root.Main', LiteralField::create('firstsave', '<p style="font-weight:bold; color:#555;">' . _t('SilverStripe\CMS\Controllers\CMSMain.SaveFirst', 'none') . '</p>'));
        }

        $GFDep = new GridField('Departments', 'Abteilungen', $this->Departments(), $DepGFConfig);
        $fields->addFieldToTab('Root.Main', $GFDep);

        $fields->addFieldToTab('Root.Main', LiteralField::create('DescDeleteIfEmptyOnly', '<p><strong>Nur Abteilungen ohne Personen können gelöscht werden!</strong></p>'));

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
        if ($this->Departments()->count()) {
            $departmentIDs = $this->Departments()->column('ID');
            // -> distinct() is a bitch
            $all = Perso::get()
                ->filter('Departments.ID', $departmentIDs)
                ->alterDataQuery(function ($query) {
                    $query->groupby('"Perso"."ID"');
                });
            return $all;
        }
    }

    // first one should be primary unless selected differently
    public function populateDefaults()
    {
        $this->Primary = 1;
        if ($PersoElements = $this->ClassName::get()->filter('Primary', 1)->count()) {
            $this->Primary = 0;
        }
        parent::populateDefaults();
    }

    public function getType()
    {
        return _t(__CLASS__ . '.BlockType', 'Team');
    }
}
