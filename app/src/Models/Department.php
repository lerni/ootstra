<?php

namespace App\Models;

use App\Models\Perso;
use App\Elements\ElementPerso;
use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\View\Parsers\URLSegmentFilter;
use SilverStripe\Forms\GridField\GridFieldPaginator;
use SilverStripe\Forms\GridField\GridFieldAddNewButton;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
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

    private static $singular_name = 'Abteilung';
    private static $plural_name = 'Abteilungen';

    private static $default_sort = 'Sort ASC';

    private static $searchable_fields = ['Title'];

    public function fieldLabels($includerelations = true)
    {
        $labels = parent::fieldLabels($includerelations);
        $labels['Title'] = _t(__CLASS__ . '.TITLE', 'Titel');

        return $labels;
    }

    private static $table_name = 'Department';

    public function getCMSFields()
    {

        $fields = parent::getCMSFields();
        $fields->removeByName('Sort');
        $fields->removeByName('Persos');
        $fields->removeByName('PersoElement');

        $PersoGFConfig = GridFieldConfig_RecordEditor::create(20);
        $PersoGFConfig->removeComponentsByType('SilverStripe\Forms\GridField\GridFieldPageCount');
        $PersoGFConfig->removeComponentsByType('SilverStripe\Forms\GridField\GridFieldAddNewButton');

        $PersoGFConfig->addComponents(
            new GridFieldDeleteAction(true),
            new GridFieldAddNewButton('toolbar-header-right')
        );

        // hack arround unsaved relations
        if ($this->isInDB()) {
            $PersoGFConfig->addComponents(
                new GridFieldOrderableRows('SortOrder'),
                new GridFieldAddExistingAutocompleter('toolbar-header-right')
            );
            $PersoGFConfig->getComponentByType(GridFieldPaginator::class)->setItemsPerPage(100);
        }

        $GFPerso = new GridField('Persos', 'Mitarbeiter', $this->Persos(), $PersoGFConfig);
        $fields->push($GFPerso);

        // $fields->addFieldToTab('Root.Main', LiteralField::create('PersosInDep', '<h2>Personen in ' . $this->Title . '</h2><p>' . $this->PersoString() . '</p>'));
        // $fields->addFieldToTab('Root.Main', LiteralField::create('DescDeleteIfEmptyOnly', '<p><strong>Nur Abteilungen ohne Personen können gelöscht werden!</strong></p>'));

        return $fields;
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

    // public function onBeforeWrite() {
    // 	$this->generateURLSegment();
    // 	parent::onBeforeWrite();
    // }

    public function generateURLSegment()
    {
        $filter = new URLSegmentFilter();
        $this->URLSegment = $filter->filter($this->Title);
    }

    public function    PersoString()
    {
        if ($this->Persos()->count()) {
            $dep = $this->Persos()->Sort('SortOrder ASC')->map()->toArray();
            $dep = implode(", ", $dep);
            return $dep;
        }
    }
}
