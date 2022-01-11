<?php

namespace App\Models;

use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\CompositeField;
use App\Elements\ElementContentSection;
use DNADesign\Elemental\Forms\TextCheckboxGroupField;

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

    private static $casting = [
        'Text' => 'HTMLText'
    ];

    private static $summary_fields = [
        'Title' => 'Title',
        'Text.Summary' => 'Text',
        'FAQSchema' => 'FAQ'
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

        return $fields;
    }
}
