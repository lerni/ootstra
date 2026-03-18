<?php

namespace App\Elements;

use App\Models\CountItem;
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

class ElementCounter extends BaseElement
{
    private static $db = [];

    private static $many_many = [
        'CountItems' => CountItem::class,
    ];

    private static $many_many_extraFields = [
        'CountItems' => [
            'SortOrder' => 'Int',
        ],
    ];

    private static $table_name = 'ElementCounter';

    private static $field_labels = [];

    private static $class_description = 'Counter Element';

    private static $icon = 'font-icon-block-reports';

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->removeByName([
            'BackgroundColor',
            'CountItems',
        ]);

        // hack around unsaved relations
        if ($this->isInDB()) {
            $CountBitsGridFieldConfig = GridFieldConfig_Base::create(20);
            $CountBitsGridFieldConfig->addComponents(
                GridFieldEditButton::create(),
                GridFieldDeleteAction::create(false),
                GridFieldDeleteAction::create(true),
                GridFieldDetailForm::create(),
                GridFieldAddNewButton::create('toolbar-header-left'),
                GridFieldAddExistingAutocompleter::create('toolbar-header-right'),
                GridFieldOrderableRows::create('SortOrder'),
            );
            $CountBitsGridFieldConfig->removeComponentsByType(GridFieldFilterHeader::class);
            $GridField = GridField::create('CountBits', 'Graphs', $this->CountItems(), $CountBitsGridFieldConfig);
            $fields->addFieldToTab('Root.Main', $GridField);
        } else {
            $fields->addFieldToTab('Root.Main', LiteralField::create('firstsave', '<p style="font-weight:bold; color:#555;">' . _t('SilverStripe\CMS\Controllers\CMSMain.SaveFirst', 'none') . '</p>'));
        }

        return $fields;
    }

    public function getType()
    {
        return _t(self::class . '.BlockType', 'Counter');
    }
}
