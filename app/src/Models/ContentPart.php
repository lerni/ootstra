<?php

namespace App\Models;

use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\CompositeField;
use App\Elements\ElementContentSection;
use SilverStripe\Versioned\GridFieldArchiveAction;
use DNADesign\Elemental\Forms\TextCheckboxGroupField;
use SilverStripe\Forms\GridField\GridFieldEditButton;
use SilverStripe\Forms\GridField\GridFieldDataColumns;
use SilverStripe\Forms\GridField\GridFieldAddNewButton;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use SilverStripe\Forms\GridField\GridFieldSortableHeader;
use SilverStripe\Forms\GridField\GridFieldAddExistingAutocompleter;

class ContentPart extends DataObject
{
    private static $db = [
        'Title' => 'Varchar',
        'Text' => 'HTMLText',
        'ShowTitle'  => 'Boolean',
        'TitleLevel' => 'Enum("1,2,3","2")',
        'DefaultOpen' => 'Boolean',
        'FAQSchema' => 'Boolean'
    ];

    private static $belongs_many_many = [
        'ElementContentSection' => ElementContentSection::class . '.ContentParts'
    ];

    private static $casting = [
        'Text' => 'HTMLText'
    ];

    private static $summary_fields = [
        'Title' => 'Title',
        'Text.Summary' => 'Text',
        'FAQSchema.Nice' => 'FAQ'
    ];

    private static $defaults = [
        'ShowTitle' => 1,
        'TitleLevel' => 2
    ];

    private static $table_name = 'ContentPart';

    public function fieldLabels($includerelations = true)
    {
        $labels = parent::fieldLabels($includerelations);
        $labels['Title'] = _t(__CLASS__ . '.TITLE', 'Titel');

        return $labels;
    }

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        if ($TextEditorField = $fields->dataFieldByName('Text')) {
            $TextEditorField->setRows(30);
        }

        // Add a combined field for "Title" and "Displayed" checkbox in a Bootstrap input group
        $fields->removeByName('ShowTitle');
        $fields->replaceField(
            'Title',
            TextCheckboxGroupField::create()
                ->setName('Title')
        );

        $TitleField = $fields->dataFieldByName('Title');
        if ($TitleField) {
            $fields->removeByName('Title');

            $TitleLevelField = $fields->dataFieldByName('TitleLevel');
            $fields->removeByName('TitleLevel');
            $TitleLevelField->setTitle(_t('DNADesign\Elemental\Models\BaseElement.TITLELEVEL', 'H1, H2, H3'));

            $TitleFieldGroup = new CompositeField(
                $TitleLevelField,
                $TitleField
            );

            $TitleFieldGroup->replaceField(
                'Title',
                TextCheckboxGroupField::create()
                    ->setName('Title')
            );
            $fields->addFieldToTab('Root.Main', $TitleFieldGroup, true);
        }

        if ($this->isInDB() && $this->ElementContentSection()->count() > 1) {
            $fields
                ->fieldByName('Root.ElementContentSection.ElementContentSection')
                ->getConfig()
                ->removeComponentsByType([
                    GridFieldAddNewButton::class,
                    GridFieldArchiveAction::class,
                    GridFieldDeleteAction::class,
                    GridFieldAddExistingAutocompleter::class,
                    GridFieldSortableHeader::class
                ]);

            $fields->fieldByName('Root.ElementContentSection.ElementContentSection')->setTitle(_t(__CLASS__ . '.IsUsedOnComment', 'This Slide is used on following Elements'));

            $fields
                ->fieldByName('Root.ElementContentSection.ElementContentSection')
                ->getConfig()
                ->getComponentByType(GridFieldDataColumns::class)
                ->setDisplayFields([
                    'getTypeBreadcrumb' => 'Element'
                ]);

            $usedGF = $fields->fieldByName('Root.ElementContentSection.ElementContentSection');
            $fields->removeByName(['ElementContentSection']);
            $fields->addFieldsToTab('Root.Main', $usedGF);
        } else {
            $fields->removeByName(['Main.ElementContentSection']);
        }

        return $fields;
    }
}
