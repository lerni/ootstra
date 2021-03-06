<?php

namespace App\Elements;

use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\Assets\Image;
use Bummzack\SortableFile\Forms\SortableUploadField;
use SilverStripe\Assets\Folder;
use SilverStripe\Forms\HeaderField;
use SilverStripe\SelectUpload\FolderDropdownField;
use SilverStripe\View\Parsers\URLSegmentFilter;

class ElementGallery extends BaseElement
{
    private static $db = [
        'CropGalleryTumbsByWidth' => 'Boolean', // todo gahh typo
        'Layout' => 'Enum("left,center,right", "center")'
    ];

    private static $has_one = [
        'GalleryFolder' => Folder::class
    ];

    private static $many_many = [
        'GalleryImages' => Image::class
    ];

    private static $many_many_extraFields = [
        'GalleryImages' => [
            'SortOrder' => 'Int'
        ]
    ];

    private static $owns = [
        'GalleryImages',
        'GalleryFolder'
    ];

    private static $table_name = 'ElementGallery';

    private static $description = 'Gallery Element';

    public function fieldLabels($includerelations = true)
    {
        $labels = parent::fieldLabels($includerelations);
        $labels['CropGalleryTumbsByWidth'] = _t(__CLASS__ . '.CROPGALLERYTUMBSBYWIDTH', 'keep aspectratio for thumbnails');

        return $labels;
    }

    private static $icon = 'font-icon-block-file';

    private static $inline_editable = false;

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->removeByName('GalleryFolder');

        $fields->addFieldToTab('Root.Main', HeaderField::create('OneOrTheOther', _t(__CLASS__ . '.OneOrTheOther', 'Choose a folder (all images contained) or upload, choose & sort directly here')));

        $FolderField = FolderDropdownField::create(
            'GalleryFolderID',
            'Folder',
            Folder::class
        );
        $fields->addFieldToTab('Root.Main', $FolderField);

        $fields->removeByName('GalleryImages');
        $fields->addFieldToTab(
            'Root.Main',
            $uploadField = new SortableUploadField(
                $name = 'GalleryImages',
                $title = 'Bilder Gallery'
            )
        );
        $filter = new URLSegmentFilter();
        $Subfolder = $filter->filter($this->Title);
        $uploadField->setFolderName('Gallery/' . $Subfolder);
        $uploadField->setSortColumn('SortOrder');
        $size = 8 * 1024 * 1024;
        $uploadField->getValidator()->setAllowedMaxFileSize($size);
        $uploadField->setDescription(_t(__CLASS__ . '.GalleryImagesDescription', 'Breite getrimmt auf 1224px'));

        return $fields;
    }

    public function Items()
    {
        if ($this->GalleryFolderID) {
            $r = Image::get()->filter(['ParentID' => $this->GalleryFolderID]);
        } else {
            $r = $this->GalleryImages()->sort('SortOrder');
        }
        return $r;
    }

    // protected function provideBlockSchema()
    // {
    // 	$blockSchema = parent::provideBlockSchema();
    // 	if ($this->Items()->first()->exists()) {
    // 		$blockSchema['fileURL'] = $this->Items()->First()->CMSThumbnail()->getURL();
    // 	}
    //     return $blockSchema;
    // }

    public function FancyGroupRand()
    {
        return(rand(1,9999));
    }

    public function getType()
    {
        return _t(__CLASS__ . '.BlockType', 'Gallery');
    }
}
