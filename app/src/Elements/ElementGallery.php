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
        'CropGalleryThumbsByWidth' => 'Boolean',
        'Layout' => 'Enum("left,center,right,slider", "center")',
        'SitemapImageExpose' => 'Boolean'
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

    private static $defaults = [
        'SitemapImageExpose' => 1
    ];

    private static $table_name = 'ElementGallery';

    private static $description = 'Gallery Element';

    private static $icon = 'font-icon-block-file';

    private static $inline_editable = false;

    public function fieldLabels($includerelations = true)
    {
        $labels = parent::fieldLabels($includerelations);
        $labels['CropGalleryThumbsByWidth'] = _t(__CLASS__ . '.CROPGALLERYTHUMBSBYWIDTH', 'keep aspectratio for thumbnails');
        $labels['SitemapImageExpose'] = _t(__CLASS__ . '.SITEMAPIMAGEEXPOSE', 'expose images in sitemap.xml');

        return $labels;
    }

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->removeByName('GalleryFolder');

        $fields->addFieldToTab('Root.Main', HeaderField::create('OneOrTheOther', _t(__CLASS__ . '.OneOrTheOther', 'Select and sort images per folder (all included) or individually')));

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
        $size = 5 * 1024 * 1024;
        $uploadField->getValidator()->setAllowedMaxFileSize($size);
        $uploadField->setDescription(_t(__CLASS__ . '.GalleryImagesDescription', 'Width trimmed to  1224px'));

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

    // public function updateBlockSchema(array &$blockSchema)
    // {
    // 	$blockSchema = parent::provideBlockSchema();
    // 	if ($this->Items() && $this->Items()->first()->exists()) {
    //         $url = $this->Items()->first()->CMSThumbnail()->getURL();
    //         $blockSchema['fileURL'] = $url;
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
