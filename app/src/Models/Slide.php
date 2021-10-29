<?php

namespace App\Models;

use SilverStripe\Assets\Image;
use SilverStripe\ORM\DataObject;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Forms\CompositeField;
use SilverStripe\Forms\TreeDropdownField;
use nathancox\EmbedField\Forms\EmbedField;
use nathancox\EmbedField\Model\EmbedObject;
use DNADesign\Elemental\Forms\TextCheckboxGroupField;

class Slide extends DataObject
{
    private static $db = [
        'Title' => 'Varchar',
        'Text' => 'Text',
        'TextAlignment' => 'Enum("center,upper-left,upper-right,lower-left,lower-right,lower-center","center")',
        'ShowTitle'  => 'Boolean',
        'TitleLevel' => 'Enum("1,2,3","2")',
        'ActionText' => 'Varchar'
    ];

    private static $has_one = [
        'SlideImage' => Image::class,
        'Link' => SiteTree::class,
        'EmbedVideo' => EmbedObject::class
    ];

    private static $owns = [
        'SlideImage'
    ];

    private static $table_name = 'Slide';

    private static $singular_name = 'Slide';
    private static $plural_name = 'Slides';

    private static $summary_fields = [
        'SlideImage.CMSThumbnail' => 'Thumbnail',
        'Title' => 'Titel',
        'Text' => 'Claim auf Bild'
    ];

    private static $searchable_fields = [
        'Title',
        'Text'
    ];

    public function fieldLabels($includerelations = true)
    {
        $labels = parent::fieldLabels($includerelations);
        $labels['Title'] = _t(__CLASS__ . '.TITLE', 'Titel');
        $labels['Text'] = _t(__CLASS__ . '.TEXT', 'Claim auf Bild');
        $labels['TextAlignment'] = _t(__CLASS__ . '.TEXTALIGNMENT', 'Anordnung Text');

        return $labels;
    }

    public function getCMSFields()
    {

        $fields = parent::getCMSFields();

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

        $RelatedPage = TreeDropdownField::create('LinkID', 'Link', SiteTree::class);
        $fields->replaceField('LinkID', $RelatedPage);

        if ($SlideBildField = $fields->dataFieldByName('SlideImage')) {
            $SlideBildField->setFolderName('Slides');
            $size = 5 * 1024 * 1024;
            $SlideBildField->getValidator()->setAllowedMaxFileSize($size);
            $SlideBildField->setDescription(_t(__CLASS__ . '.SlideImageDescription', 'small 4:1 // medium 16:9 // fullscreen 8:5 / 5:8 / 4:3 depending on client screensize (use focuspoint!)'));
        }

        $fields->addFieldToTab('Root.Main', EmbedField::create('EmbedVideoID', 'Embed Video'));

        return $fields;
    }
}
