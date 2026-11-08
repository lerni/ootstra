<?php

namespace App\Elements;

use App\Models\ContentPart;
use Spatie\SchemaOrg\Schema;
use App\Utility\GridFieldHelper;
use App\Schema\SchemaIdentifiers;
use SilverStripe\Control\Director;
use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\Forms\GridField\GridField;
use App\GridField\GridFieldConfig_SortableRelation;

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

        GridFieldHelper::addIfSaved($fields, $this, fn () => GridField::create('ContentParts', 'Content Parts', $this->ContentParts(), GridFieldConfig_SortableRelation::create('SortOrder')));

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
        // Current page first: a virtual (linked) element belongs to the page rendering it
        $page = Director::get_current_page();
        $pageUrl = ($page && $page->hasMethod('AbsoluteLink') ? $page->AbsoluteLink() : null)
            ?: $this->getPage()?->AbsoluteLink();
        if ($pageUrl) {
            // One FAQPage per page; SchemaRegistry merges the questions of all sections
            $schemaFAQ
                ->setProperty('@id', SchemaIdentifiers::forUrl($pageUrl, 'faq'))
                ->isPartOf(Schema::webPage()->setProperty('@id', SchemaIdentifiers::webPageId($pageUrl)));
        }

        return [$schemaFAQ];
    }

    public function getType()
    {
        return _t(self::class . '.BlockType', 'Accordion');
    }
}
