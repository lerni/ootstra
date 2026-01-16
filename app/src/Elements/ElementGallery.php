<?php

namespace App\Elements;

use SilverStripe\Assets\Image;
use SilverStripe\Assets\Folder;
use SilverStripe\Forms\HeaderField;
use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\View\Parsers\URLSegmentFilter;
use SilverStripe\SelectUpload\FolderDropdownField;
use Bummzack\SortableFile\Forms\SortableUploadField;

class ElementGallery extends BaseElement
{
    private static $db = [
        'Layout' => 'Enum("grid,slider,flex", "slider")',
        'Alignment' => 'Enum("left,center,right", "left")',
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
        'SitemapImageExpose' => true,
        'isFullWidth' => false,
        'Layout' => 'slider'
    ];

    private static $table_name = 'ElementGallery';

    private static $class_description = 'Gallery Element';

    private static $icon = 'font-icon-block-file';

    public function fieldLabels($includerelations = true)
    {
        $labels = parent::fieldLabels($includerelations);
        $labels['Alignment'] = _t(__CLASS__ . '.ALIGNMENT', 'Alignment (flex only)');
        $labels['SitemapImageExpose'] = _t(__CLASS__ . '.SITEMAPIMAGEEXPOSE', 'expose images in sitemap.xml');

        return $labels;
    }

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->removeByName([
            'GalleryFolder'
        ]);

        $fields->addFieldToTab('Root.Main', HeaderField::create('OneOrTheOther', _t(__CLASS__ . '.OneOrTheOther', 'Choose pictures by folder (all included) or pick & sort individually')));

        $FolderField = FolderDropdownField::create(
            'GalleryFolderID',
            _t(__CLASS__ . '.FOLDER', 'Folder'),
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
        return (random_int(1, 9999));
    }

    public function getType()
    {
        return _t(__CLASS__ . '.BlockType', 'Gallery');
    }
}
