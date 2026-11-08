<?php

namespace App\Elements;

use App\Models\PDFDoc;
use App\Utility\GridFieldHelper;
use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\Forms\GridField\GridField;
use App\GridField\GridFieldConfig_SortableRelation;

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

        GridFieldHelper::addIfSaved($fields, $this, fn () => GridField::create(
            'PDFDocs',
            '',
            $this->PDFDocs(),
            GridFieldConfig_SortableRelation::create('PDFSortOrder')->setAddNewLabel(_t(self::class . '.AddDocument', 'Add document...')),
        ));

        return $fields;
    }

    public function getType()
    {
        return _t(self::class . '.BlockType', 'PDF Document');
    }
}
