<?php

namespace App\Elements;

use App\Models\Perso;
use SilverStripe\Forms\LiteralField;
use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldPageCount;
use SilverStripe\Forms\GridField\GridFieldPaginator;
use SilverStripe\Forms\GridField\GridFieldAddNewButton;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
use SilverStripe\Forms\GridField\GridFieldAddExistingAutocompleter;

class ElementPersoCFA extends BaseElement
{

    private static $db = [
        'CountMax' => 'Int',
        'Sorting' => 'Enum("random,manual","random")'
    ];

    private static $has_one = [];

    private static $has_many = [];

    private static $many_many = [
        'Persos' => Perso::class
    ];

    private static $many_many_extraFields = [
        'Persos' => [
            'SortOrder' => 'Int'
        ]
    ];

    private static $owns = [
        'Persos'
    ];

    private static $table_name = 'ElementPersoCFA';

    private static $defaults = [
        'CountMax' => 3
    ];

    private static $description = 'Call for Contact Perso-Element';

    private static $title = 'Contact';

    private static $singular_name = 'Contact';

    private static $plural_name = 'Contacts';

    private static $icon = 'font-icon-block-user';

    public function fieldLabels($includerelations = true)
    {
        $labels = parent::fieldLabels($includerelations);
        $labels['CountMax'] = _t(__CLASS__ . '.COUNTMAX', 'Number (default 3)');
        return $labels;
    }

    function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->removeByName([
            'isFullWidth',
            'Persos'
        ]);

        // hack around unsaved relations
        if ($this->isInDB()) {
            $PersoGFConfig = GridFieldConfig_RecordEditor::create(20);
            $PersoGFConfig->removeComponentsByType(GridFieldPageCount::class);
            $PersoGFConfig->removeComponentsByType(GridFieldAddNewButton::class);

            $PersoGFConfig->addComponents(
                new GridFieldDeleteAction(true),
                new GridFieldAddNewButton('toolbar-header-right')
            );

            $PersoGFConfig->addComponents(
                new GridFieldOrderableRows('SortOrder'),
                new GridFieldAddExistingAutocompleter('toolbar-header-right')
            );
            $PersoGFConfig->getComponentByType(GridFieldPaginator::class)->setItemsPerPage(100);

            $GFPerso = new GridField('Persos', _t(__CLASS__ . '.PERSOS', 'Employees'), $this->Persos(), $PersoGFConfig);
            $fields->push($GFPerso);
        } else {
            $fields->addFieldToTab('Root.Main', LiteralField::create('firstsave', '<p style="font-weight:bold; color:#555;">' . _t('SilverStripe\CMS\Controllers\CMSMain.SaveFirst', 'none') . '</p>'));
        }
        return $fields;
    }

    public function Items()
    {
        $items = $this->Persos();
        if ($this->Sorting == 'random') {
            $items = $items->shuffle();
        } else {
            $items = $items->sort('SortOrder');
        }
        if ($this->CountMax) {
            $items = $items->limit($this->CountMax);
        }
        return $items;
    }

    protected function provideBlockSchema()
    {
        $blockSchema = parent::provideBlockSchema();
        if ($this->Items()->count() && $this->Items()->First()->Portrait()->exists()) {
            $blockSchema['fileURL'] = $this->Items()->First()->Portrait()->CMSThumbnail()->getURL();
        }
        return $blockSchema;
    }

    public function getType()
    {
        return _t(__CLASS__ . '.BlockType', 'Contact (CFA)');
    }

    public function PrimaryElementPersoController() {
        $elementPerso = ElementPerso::get()->filter(['Primary' => 1])->first();
        if ($elementPerso) {
            return $elementPerso->getController();
        }
    }
}
