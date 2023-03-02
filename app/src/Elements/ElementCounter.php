<?php

namespace App\Elements;

use App\Models\CountItem;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldAddNewButton;
use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\Forms\GridField\GridFieldConfig_Base;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use SilverStripe\Forms\GridField\GridFieldDetailForm;
use SilverStripe\Forms\GridField\GridFieldEditButton;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;

class ElementCounter extends BaseElement
{
    private static $db = [];

    private static $many_many = [
        'CountItems' => CountItem::class
    ];

    private static $many_many_extraFields = [
        'CountItems' => [
            'SortOrder' => 'Int'
        ]
    ];

    private static $table_name = 'ElementCounter';

    private static $field_labels = [];

    private static $description = 'Counter Element';

    private static $icon = 'font-icon-block-reports';

    private static $inline_editable = false;

    function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->removeByName([
            'CountItems',
            'BackgroundColor'
        ]);

        // hack around unsaved relations
        if ($this->isInDB()) {
            $CountBitsGridFieldConfig = GridFieldConfig_Base::create(20);
            $CountBitsGridFieldConfig->addComponents(
                new GridFieldEditButton(),
                new GridFieldDeleteAction(false),
                new GridFieldDetailForm(),
                new GridFieldAddNewButton('toolbar-header-right')
            );
            $CountBitsGridFieldConfig->addComponent(new GridFieldOrderableRows('SortOrder'));
            $GridField = new GridField('CountBits', 'Graphs', $this->CountItems(), $CountBitsGridFieldConfig);
            $fields->addFieldToTab('Root.Main', $GridField);
        } else {
            $fields->addFieldToTab('Root.Main', LiteralField::create('firstsave', '<p style="font-weight:bold; color:#555;">' . _t('SilverStripe\CMS\Controllers\CMSMain.SaveFirst', 'none') . '</p>'));
        }

        return $fields;
    }

    public function getType()
    {
        return _t(__CLASS__ . '.BlockType', 'Counter');
    }
}
