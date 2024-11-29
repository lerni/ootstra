<?php

namespace App\Models;

use App\Elements\ElementHero;
use SilverStripe\Assets\Image;
use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\FieldGroup;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\Forms\TreeDropdownField;
use SilverStripe\Versioned\GridFieldArchiveAction;
use DNADesign\Elemental\Forms\TextCheckboxGroupField;
use SilverStripe\Forms\GridField\GridFieldDataColumns;
use SilverStripe\Forms\GridField\GridFieldAddNewButton;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use SilverStripe\Forms\GridField\GridFieldSortableHeader;
use SilverStripe\Forms\GridField\GridFieldAddExistingAutocompleter;

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
        'Link' => SiteTree::class
    ];

    private static $belongs_many_many = [
        'Hero' => ElementHero::class . '.Slides'
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

        $fields->removeByName([
            'ShowTitle'
        ]);

        $TitleField = $fields->dataFieldByName('Title');
        if ($TitleField) {
            $fields->removeByName('Title');

            $TitleLevelField = $fields->dataFieldByName('TitleLevel');
            $fields->removeByName('TitleLevel');
            $TitleLevelField->setTitle(_t('DNADesign\Elemental\Models\BaseElement.TITLELEVEL', 'H1, H2, H3'));

            $TitleFieldGroup = new FieldGroup(
                $TitleLevelField,
                $TitleField
            );

            $TitleFieldGroup->replaceField(
                'Title',
                TextCheckboxGroupField::create()
                    ->setName('Title')
            );
            $fields->fieldByName('Root.Main')->unshift($TitleFieldGroup);
        }

        $RelatedPage = TreeDropdownField::create('LinkID', 'Link', SiteTree::class);
        $fields->replaceField('LinkID', $RelatedPage);

        if ($SlideBildField = $fields->dataFieldByName('SlideImage')) {
            $SlideBildField->setFolderName('Slides');
            if ($this->Hero()->count()) {
                $currentHeroSize = $this->Hero()->first()->HeroSize;
                $currentHeroAspectRatio = ElementHero::$AvaliableHeroSizes[$currentHeroSize];
                $SlideBildField->setDescription(_t(__CLASS__ . '.SlideImageDescription', '{aspectRatio} - use focuspoint!', [ 'aspectRatio' => $currentHeroAspectRatio ]));
            }
        }

        if ($this->isInDB() && $this->Hero()->count() > 1) {
            $fields
                ->fieldByName('Root.Hero.Hero')
                ->getConfig()
                ->removeComponentsByType([
                    GridFieldAddNewButton::class,
                    GridFieldArchiveAction::class,
                    GridFieldDeleteAction::class,
                    GridFieldAddExistingAutocompleter::class,
                    GridFieldSortableHeader::class
                ]);

            $fields->fieldByName('Root.Hero.Hero')->setTitle(_t(__CLASS__ . '.IsUsedOnComment', 'This Slide is used on following Elements'));

            $fields
                ->fieldByName('Root.Hero.Hero')
                ->getConfig()
                ->getComponentByType(GridFieldDataColumns::class)
                ->setDisplayFields([
                    'getTypeBreadcrumb' => 'Element'
                ]);

            $usedGF = $fields->fieldByName('Root.Hero.Hero');
            $fields->removeByName(['Hero']);
            $fields->addFieldsToTab('Root.Main', $usedGF);
        } else {
            $fields->removeByName(['Hero']);
        }

        return $fields;
    }

    public function getCMSValidator()
    {
        return new RequiredFields([
            'Title'
        ]);
    }
}
