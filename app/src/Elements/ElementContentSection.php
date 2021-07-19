<?php

namespace App\Elements;

use App\Models\ContentPart;
use Spatie\SchemaOrg\Schema;
use SilverStripe\Forms\LiteralField;
use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldDetailForm;
use SilverStripe\Forms\GridField\GridFieldEditButton;
use SilverStripe\Forms\GridField\GridFieldConfig_Base;
use SilverStripe\Forms\GridField\GridFieldAddNewButton;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use SilverStripe\Forms\GridField\GridFieldAddExistingAutocompleter;
use SwiftDevLabs\DuplicateDataObject\Forms\GridField\GridFieldDuplicateAction;

class ElementContentSection extends BaseElement
{
    private static $db = [
        'HTML' => 'HTMLText',
        'Layout' => 'Enum("Accordion,Textblocks","Accordion")'
    ];

    private static $many_many = [
        'ContentParts' => ContentPart::class
    ];

    private static $many_many_extraFields = [
        'ContentParts' => [
            'SortOrder' => 'Int'
        ]
    ];

    private static $field_labels = [];

    private static $description = 'Content Section Element';

    private static $table_name = 'ElementContentSection';

    private static $icon = 'font-icon-block-table-data';

    private static $inline_editable = false;

    function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->removeByName('isFullWidth');

        if ($LayoutField = $fields->dataFieldByName('Layout')) {
            $fields->insertBefore($LayoutField, 'HTML');
        }

        if ($TextEditorField = $fields->dataFieldByName('HTML')) {
            $TextEditorField->setRows(16);
            $TextEditorField->setAttribute('data-mce-body-class', $this->ShortClassName());
            $TextEditorField->addExtraClass('stacked');
        }

        $fields->removeByName('ContentParts');

        // hack arround unsaved relations
        if ($this->isInDB()) {
            $ContentPartsGridFieldConfig = GridFieldConfig_Base::create(20);
            $ContentPartsGridFieldConfig->addComponents(
                new GridFieldEditButton(),
                new GridFieldDeleteAction(false),
                new GridFieldDeleteAction(true),
                new GridFieldDetailForm(),
                new GridFieldAddNewButton('toolbar-header-right'),
                new GridFieldAddExistingAutocompleter('toolbar-header-right')
                // new GridFieldDuplicateAction()
            );
            $ContentPartsGridFieldConfig->addComponent(new GridFieldOrderableRows('SortOrder'));
            $GridField = new GridField('ContentParts', 'Content Parts', $this->ContentParts(), $ContentPartsGridFieldConfig);
            $fields->addFieldToTab('Root.Main', $GridField);
        } else {
            $fields->addFieldToTab('Root.Main', LiteralField::create('firstsave', '<p style="font-weight:bold; color:#555;">' . _t('SilverStripe\CMS\Controllers\CMSMain.SaveFirst', 'none') . '</p>'));
        }

        return $fields;
    }

    public function getFAQParts()
    {
        return $this->ContentParts()->filter(['FAQSchema' => 1]);

    }

    public function FAQSchema()
    {

        $FAQParts = $this->getFAQParts();

        $schemaFAQ = Schema::fAQPage();

        if ($FAQParts->Count()) {

            $faqs = [];
            $i = 0;
            foreach ($FAQParts as $faq) {

                $PushFAQ = Schema::question()
                    ->name($faq->Title)
                    ->acceptedAnswer(Schema::Answer()
                        ->text($faq->Text)
                );

                $faqs[$i] = $PushFAQ;
                $i++;
            }

            return $schemaFAQ->mainEntity($faqs)->toScript();
        }
    }

    public function getType()
    {
        return _t(__CLASS__ . '.BlockType', 'Accordion');
    }
}
