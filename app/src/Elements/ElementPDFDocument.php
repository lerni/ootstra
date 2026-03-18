<?php

namespace App\Elements;

use App\Models\PDFDoc;
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

class ElementPDFDocument extends BaseElement
{
    private static $db = [
        'Layout' => 'Enum("third,halve", "third")',
        'ShowAsSlider' => 'Boolean',
    ];

    private static $has_many = [];

    private static $many_many = [
        'PDFDocs' => PDFDoc::class,
    ];

    private static $many_many_extraFields = [
        'PDFDocs' => [
            'PDFSortOrder' => 'Int',
        ],
    ];

    private static $owns = [
        'PDFDocs',
    ];

    private static $table_name = 'ElementPDFDocument';

    private static $class_description = 'PDF Element';

    private static $field_labels = [];

    private static $icon = 'font-icon-block-virtual-page';

    public function fieldLabels($includerelations = true)
    {
        $labels = parent::fieldLabels($includerelations);
        $labels['ShowAsSlider'] = _t(self::class . '.SHOWASSLIDER', 'Show as slider');

        return $labels;
    }

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->removeByName([
            'PDFDocs',
        ]);

        if ($TextEditorField = $fields->dataFieldByName('HTML')) {
            $TextEditorField->setRows(10);
        }

        // hack around unsaved relations
        if ($this->isInDB()) {
            $DocumentGridFieldConfig = GridFieldConfig_Base::create(20);
            $DocumentGridFieldConfig->addComponents(
                GridFieldEditButton::create(),
                GridFieldDeleteAction::create(false),
                GridFieldDeleteAction::create(true),
                GridFieldDetailForm::create(),
                (GridFieldAddNewButton::create('toolbar-header-left'))->setButtonName(_t(self::class . '.AddDocument', 'Add document...')),
                GridFieldAddExistingAutocompleter::create('toolbar-header-right'),
                GridFieldOrderableRows::create('PDFSortOrder'),
            );
            $gridField = GridField::create('PDFDocs', '', $this->PDFDocs(), $DocumentGridFieldConfig);
            $fields->addFieldToTab('Root.Main', $gridField);
            $DocumentGridFieldConfig->removeComponentsByType([
                GridFieldFilterHeader::class,
            ]);
        } else {
            $fields->addFieldToTab('Root.Main', LiteralField::create('firstsave', '<p style="font-weight:bold; color:#555;">' . _t('SilverStripe\CMS\Controllers\CMSMain.SaveFirst', 'none') . '</p>'));
        }

        return $fields;
    }

    public function getType()
    {
        return _t(self::class . '.BlockType', 'PDF Document');
    }
}
