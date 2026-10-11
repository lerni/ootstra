<?php

namespace App\Elements;

use App\Models\ContentPart;
use Spatie\SchemaOrg\Schema;
use App\Schema\SchemaIdentifiers;
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
        'Layout' => 'Enum("Accordion,Textblocks,NumberedList","Accordion")',
    ];

    private static $many_many = [
        'ContentParts' => ContentPart::class,
    ];

    private static $many_many_extraFields = [
        'ContentParts' => [
            'SortOrder' => 'Int',
        ],
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
            'ContentParts',
        ]);

        // hack around unsaved relations
        if ($this->isInDB()) {
            $ContentPartsGridFieldConfig = GridFieldConfig_Base::create(20);
            $ContentPartsGridFieldConfig->addComponents(
                GridFieldEditButton::create(),
                GridFieldDeleteAction::create(false),
                GridFieldDeleteAction::create(true),
                GridFieldDetailForm::create(),
                GridFieldAddNewButton::create('toolbar-header-left'),
                GridFieldAddExistingAutocompleter::create('toolbar-header-right'),
                GridFieldOrderableRows::create('SortOrder'),
            );
            $ContentPartsGridFieldConfig->removeComponentsByType(GridFieldFilterHeader::class);
            $GridField = GridField::create('ContentParts', 'Content Parts', $this->ContentParts(), $ContentPartsGridFieldConfig);
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

    public function provideSchemaEntities(): array
    {
        $faqs = [];
        foreach ($this->getFAQParts() as $faq) {
            $faqs[] = Schema::question()
                ->name($faq->FAQTitle ?: $faq->Title)
                ->acceptedAnswer(
                    Schema::Answer()
                        ->text($faq->Text),
                );
        }

        if (!$faqs) {
            return [];
        }

        $schemaFAQ = Schema::fAQPage()->mainEntity($faqs);
        if ($pageUrl = $this->getPage()?->AbsoluteLink()) {
            $schemaFAQ->setProperty('@id', SchemaIdentifiers::forUrl($pageUrl, 'faq-' . $this->ID));
        }

        return [$schemaFAQ];
    }

    public function getType()
    {
        return _t(self::class . '.BlockType', 'Accordion');
    }
}
