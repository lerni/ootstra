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
use SilverStripe\Forms\GridField\GridFieldFilterHeader;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use SilverStripe\Forms\GridField\GridFieldAddExistingAutocompleter;

class ElementContentSection extends BaseElement
{
    private static $db = [
        'Layout' => 'Enum("Accordion,Textblocks,NumberedList","Accordion")'
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

    private static $class_description = 'Content Section Element';

    private static $table_name = 'ElementContentSection';

    private static $icon = 'font-icon-block-table-data';

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->removeByName([
            'isFullWidth',
            'ContentParts'
        ]);

        // hack around unsaved relations
        if ($this->isInDB()) {
            $ContentPartsGridFieldConfig = GridFieldConfig_Base::create(20);
            $ContentPartsGridFieldConfig->addComponents(
                new GridFieldEditButton(),
                new GridFieldDeleteAction(false),
                new GridFieldDeleteAction(true),
                new GridFieldDetailForm(),
                new GridFieldAddNewButton('toolbar-header-left'),
                new GridFieldAddExistingAutocompleter('toolbar-header-right'),
                new GridFieldOrderableRows('SortOrder')
            );
            $ContentPartsGridFieldConfig->removeComponentsByType(GridFieldFilterHeader::class);
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
                    ->acceptedAnswer(
                        Schema::Answer()
                            ->text($faq->Text)
                    );

                if ($faq->FAQTitle) {
                    $PushFAQ->name($faq->FAQTitle);
                } else {
                    $PushFAQ->name($faq->Title);
                }

                $faqs[$i] = $PushFAQ;
                ++$i;
            }

            return $schemaFAQ->mainEntity($faqs)->toScript();
        }
    }

    public function getType()
    {
        return _t(__CLASS__ . '.BlockType', 'Accordion');
    }
}
