<?php

namespace App\Elements;

use App\Models\Perso;
use SilverStripe\Forms\LiteralField;
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

class ElementPersoCFA extends BaseElement
{
    private static $db = [
        'Above' => 'HTMLText',
        'CountMax' => 'Int',
        'Layout' => 'Enum("left,right", "right")',
        'Sorting' => 'Enum("random,manual","random")',
    ];

    private static $has_one = [];

    private static $has_many = [];

    private static $many_many = [
        'Persos' => Perso::class,
    ];

    private static $many_many_extraFields = [
        'Persos' => [
            'SortOrder' => 'Int',
        ],
    ];

    private static $owns = [
        'Persos',
    ];

    private static $table_name = 'ElementPersoCFA';

    private static $defaults = [
        'CountMax' => 3,
    ];

    private static $class_description = 'Call for Contact Perso-Element';

    private static $title = 'Contact';

    private static $singular_name = 'Contact';

    private static $plural_name = 'Contacts';

    private static $icon = 'font-icon-block-user';

    public function fieldLabels($includerelations = true)
    {
        $labels = parent::fieldLabels($includerelations);
        $labels['CountMax'] = _t(self::class . '.COUNTMAX', 'Number (default 3)');
        $labels['Layout'] = _t(self::class . '.LAYOUT', 'Alignment text');

        return $labels;
    }

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->removeByName([
            'isFullWidth',
            'Persos',
        ]);

        // hack around unsaved relations
        if ($this->isInDB()) {
            $PersoGFConfig = GridFieldConfig_Base::create(30);
            $PersoGFConfig->addComponents(
                GridFieldEditButton::create(),
                GridFieldDeleteAction::create(true),
                GridFieldDetailForm::create(),
                GridFieldAddNewButton::create('toolbar-header-left'),
                GridFieldAddExistingAutocompleter::create('toolbar-header-right'),
            );
            if ($this->Sorting == 'manual') {
                $PersoGFConfig->addComponent(GridFieldOrderableRows::create('SortOrder'));
            }
            $PersoGFConfig->removeComponentsByType(GridFieldFilterHeader::class);
            $GFPerso = GridField::create('Persos', _t(self::class . '.PERSOS', 'Employees'), $this->Persos(), $PersoGFConfig);
            $fields->addFieldToTab('Root.Main', $GFPerso);
        } else {
            $fields->addFieldToTab('Root.Main', LiteralField::create('firstsave', '<p style="font-weight:bold; color:#555;">' . _t('SilverStripe\CMS\Controllers\CMSMain.SaveFirst', 'none') . '</p>'));
        }

        return $fields;
    }

    public function Items()
    {
        $items = $this->Persos();
        $items = $this->Sorting == 'random' ? $items->shuffle() : $items->sort('SortOrder');
        if ($this->CountMax) {
            $items = $items->limit($this->CountMax);
        }

        return $items;
    }

    protected function provideBlockSchema()
    {
        $blockSchema = parent::provideBlockSchema();
        if ($this->Items()->count() && $this->Items()->first()->Portrait()->exists()) {
            $blockSchema['fileURL'] = $this->Items()->first()->Portrait()->CMSThumbnail()->getURL();
        }

        return $blockSchema;
    }

    public function getType()
    {
        return _t(self::class . '.BlockType', 'Contact (CFA)');
    }
}
