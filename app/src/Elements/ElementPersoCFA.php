<?php

namespace App\Elements;

use App\Models\Perso;
use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig_Base;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use SilverStripe\Forms\GridField\GridFieldAddExistingAutocompleter;
use SilverStripe\Forms\LiteralField;

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

    private static $description = 'Call for Contact Perso Element';

    private static $title = 'Ansprechpartner';

    private static $singular_name = 'Ansprechpartner';

    private static $plural_name = 'Ansprechpartner';

    private static $icon = 'font-icon-block-user';

    private static $inline_editable = false;

    public function fieldLabels($includerelations = true)
    {
        $labels = parent::fieldLabels($includerelations);
        $labels['CountMax'] = _t(__CLASS__ . '.COUNTMAX', 'Anzahl (default 3)');
        return $labels;
    }

    function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->removeByName('isFullWidth');

        $fields->removeByName('Persos');

        // hack arround unsaved relations
        if ($this->isInDB()) {
            $PersoGFConfig = GridFieldConfig_Base::create(20);
            $PersoGFConfig->removeComponentsByType([
                GridFieldFilterHeader::class
            ]);
            $PersoGFConfig->addComponents(
                new GridFieldAddExistingAutocompleter('toolbar-header-right'),
                new GridFieldDeleteAction(true)
            );
            $PersoGFConfig->addComponent(new GridFieldOrderableRows('SortOrder'));
            $GFPerso = new GridField('Persos', 'Personen', $this->Persos(), $PersoGFConfig);
            $fields->addFieldToTab('Root.Main', $GFPerso);
        } else {
            $fields->addFieldToTab('Root.Main', LiteralField::create('firstsave', '<p style="font-weight:bold; color:#555;">' . _t('SilverStripe\CMS\Controllers\CMSMain.SaveFirst', 'none') . '</p>'));
        }
        return $fields;
    }

    public function Items()
    {
        $items = $this->Persos();
        if ($this->Sorting == 'random') {
            $items = $items->sort('RAND()');
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
}
