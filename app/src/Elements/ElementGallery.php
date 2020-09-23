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
        'CropGalleryTumbsByWidth' => 'Boolean',
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

    private static $field_labels = [
        'CropGalleryTumbsByWidth' => 'keep aspectratio for thumbnails'
    ];

    private static $inline_editable = false;

    private static $icon = 'font-icon-p-gallery';

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->removeByName('GalleryFolder');

        $fields->addFieldToTab('Root.Main', HeaderField::create('oneOrTheOther', 'Choose a folder (all images contained) OR upload/choose/sort directly'));

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
        $uploadField->setDescription('Breite getrimmt auf 1200px');

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

    public function getType()
    {
        return _t(__CLASS__ . '.BlockType', 'false');
    }
}
