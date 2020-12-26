<?php

namespace App\Models;

use SilverStripe\Assets\Image;
use App\Elements\ElementTeaser;
use SilverStripe\ORM\DataObject;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Forms\TreeDropdownField;

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
        'TeaserElements' => ElementTeaser::class
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

    public function getCMSFields()
    {

        $fields = parent::getCMSFields();

        if ($uploadField = $fields->dataFieldByName('Image')) {
            $uploadField->setFolderName('Teasers');
            $uploadField->setDescription(_t(__CLASS__ . '.ImageDescription', 'min. 600x600px'));
        }

        if ($teaserActionField = $fields->dataFieldByName('Action')) {
            $teaserActionField->setDescription('Default: "' . _t('App\Models\Teaser.MORE', 'Mehr erfahren') . '"');
        }

        // text left or right is available just for fullwidth layout
        if (!$this->TeaserElements()->filter(['Layout' => 'full'])->count()) {
            $fields->removeByName("Layout");
        }

        $RelatedPage = TreeDropdownField::create('RelatedPageID', 'Link', SiteTree::class);
        $fields->replaceField('RelatedPageID', $RelatedPage);

        return $fields;
    }
}
