<?php

namespace App\Models;

use SilverStripe\Assets\Image;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Forms\TreeDropdownField;
use SilverStripe\ORM\DataObject;

class Slide extends DataObject
{
    private static $db = [
        'Title' => 'Varchar',
        'TextTitle' => 'Text',
        'TextAlignment' => 'Enum("center,upper-left,upper-right,lower-left,lower-right,lower-center","center")'
    ];
    private static $has_one = [
        'SlideImage' => Image::class,
        'Link' => SiteTree::class
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
        'TextTitle' => 'Claim auf Bild'
    ];

    private static $searchable_fields = [
        'Title',
        'TextTitle'
    ];

    public function fieldLabels($includerelations = true)
    {
        $labels = parent::fieldLabels($includerelations);
        $labels['Title'] = _t(__CLASS__ . '.TITLE', 'Titel');
        $labels['TextTitle'] = _t(__CLASS__ . '.TEXTTITLE', 'Claim auf Bild');
        $labels['TextAlignment'] = _t(__CLASS__ . '.TEXTALIGNMENT', 'Anordnung Text');

        return $labels;
    }

    public function getCMSFields()
    {

        $fields = parent::getCMSFields();

        $RelatedPage = TreeDropdownField::create('LinkID', 'Link', SiteTree::class);
        $fields->replaceField('LinkID', $RelatedPage);

        if ($SlideBildField = $fields->dataFieldByName('SlideImage')) {
            $SlideBildField->setFolderName('Slides');
            $SlideBildField->setDescription('small 4:1 // medium 16:9 // fullscreen 8:5 / 5:8 / 4:3 depending on client screensize (use focuspoint!)');
        }

        return $fields;
    }
}
