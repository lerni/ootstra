<?php

namespace App\Models;

use SilverStripe\Assets\Image;
use App\Elements\ElementTeaser;
use SilverStripe\ORM\DataObject;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\Forms\TreeDropdownField;
use SilverStripe\Versioned\GridFieldArchiveAction;
use SilverStripe\Forms\GridField\GridFieldDataColumns;
use SilverStripe\Forms\GridField\GridFieldAddNewButton;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use SilverStripe\Forms\GridField\GridFieldSortableHeader;
use SilverStripe\Forms\GridField\GridFieldAddExistingAutocompleter;

class Teaser extends DataObject
{
    private static $db = [
        'Title' => 'Text',
        'Text' => 'Text',
        'Action' => 'Varchar',
        'Layout' => 'Enum("left,right", "right")'
    ];

    private static $has_one = [
        'Image' => Image::class,
        'RelatedPage' => SiteTree::class
    ];

    private static $belongs_many_many = [
        'TeaserElements' => ElementTeaser::class . '.Teasers'
    ];

    private static $owns = [
        'Image'
    ];

    private static $singular_name = 'Teaser';
    private static $plural_name = 'Teasers';

    private static $table_name = 'Teaser';

    private static $summary_fields = [
        'Image.CMSThumbnail' => 'Thumbnail',
        'Title' => 'Titel'
    ];

    private static $searchable_fields = [
        'Title',
        'Text'
    ];

    public function fieldLabels($includerelations = true)
    {
        $labels = parent::fieldLabels($includerelations);
        $labels['Layout'] = _t(__CLASS__ . '.LAYOUT', 'Alignment text');
        return $labels;
    }

    public function getCMSFields()
    {

        $fields = parent::getCMSFields();

        if ($uploadField = $fields->dataFieldByName('Image')) {
            $uploadField->setFolderName('Teasers');
            $uploadField->setDescription(_t(__CLASS__ . '.ImageDescription', 'min. 600x600px'));
        }

        if ($teaserActionField = $fields->dataFieldByName('Action')) {
            $teaserActionField->setAttribute('placeholder', _t('App\Models\Teaser.MORE', 'Learn more'));
        }

        // text left or right is available just for fullwidth layout
        if (!$this->TeaserElements()->filter(['Layout' => 'full'])->count()) {
            $fields->removeByName("Layout");
        }

        $RelatedPage = TreeDropdownField::create('RelatedPageID', 'Link', SiteTree::class);
        $fields->replaceField('RelatedPageID', $RelatedPage);

        if ($this->isInDB() && $this->TeaserElements()->count() > 1) {
            $fields
                ->fieldByName('Root.TeaserElements.TeaserElements')
                ->getConfig()
                ->removeComponentsByType([
                    GridFieldAddNewButton::class,
                    GridFieldArchiveAction::class,
                    GridFieldDeleteAction::class,
                    GridFieldAddExistingAutocompleter::class,
                    GridFieldSortableHeader::class
                ]);

            $fields->fieldByName('Root.TeaserElements.TeaserElements')->setTitle(_t(__CLASS__ . '.IsUsedOnComment', 'This Teaser is used on following Elements'));

            $fields
                ->fieldByName('Root.TeaserElements.TeaserElements')
                ->getConfig()
                ->getComponentByType(GridFieldDataColumns::class)
                ->setDisplayFields([
                    'getTypeBreadcrumb' => 'Element'
                ]);

            $usedGF = $fields->fieldByName('Root.TeaserElements.TeaserElements');
            $fields->removeByName(['TeaserElements']);
            $fields->addFieldsToTab('Root.Main', $usedGF);
        } else {
            $fields->removeByName(['TeaserElements']);
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
