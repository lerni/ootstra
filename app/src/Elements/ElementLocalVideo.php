<?php

namespace App\Elements;

use SilverStripe\Assets\File;
use SilverStripe\Assets\Image;
use SilverStripe\CMS\Model\SiteTree;
use DNADesign\Elemental\Models\BaseElement;

class ElementLocalVideo extends BaseElement
{
    private static $db = [
        'ActionText' => 'Varchar',
        'Autoplay' => 'Boolean',
        'Loop' => 'Boolean',
        'Mute' => 'Boolean'
    ];

    private static $has_one = [
        'Image' => Image::class,
        'RelatedPage' => SiteTree::class,
        'LocalMP4Video' => File::class
    ];

    private static $has_many = [];

    private static $many_many = [];

    private static $owns = [
        'Image',
        'LocalMP4Video'
    ];

    private static $table_name = 'ElementLocalVideo';

    private static $title = 'Local video element';

    private static $icon = 'font-icon-block-video';

    public function fieldLabels($includerelations = true)
    {
        $labels = parent::fieldLabels($includerelations);
        $labels['Image'] = _t(__CLASS__ . '.IMAGE', 'Poster/still image');
        $labels['RelatedPage'] = _t(__CLASS__ . '.LINK', 'Link action');
        $labels['Autoplay'] = _t(__CLASS__ . '.LINK', 'Autoplay - enforces "Mute"');
        $labels['Loop'] = _t(__CLASS__ . '.LINK', 'Looping video');
        $labels['Mute'] = _t(__CLASS__ . '.MUTE', 'Mute initial state');
        return $labels;
    }

    function getCMSFields()
    {
        $fields = parent::getCMSFields();

        if ($linkField = $fields->dataFieldByName('RelatedPageID')) {
            $fields->insertAfter('ActionText', $linkField);
        }

        if ($uploadField = $fields->dataFieldByName('Image')) {
            $uploadField->setFolderName('Video');
            $size = 5 * 1024 * 1024;
            $uploadField->getValidator()->setAllowedMaxFileSize($size);
            $uploadField->setDescription(_t(__CLASS__ . '.ImageDescription', '16:9'));
        }

        if ($uploadField = $fields->dataFieldByName('LocalMP4Video')) {
            $uploadField->setFolderName('Video');
            $uploadField->allowedExtensions  = ['mp4'];
            $size = 20 * 1024 * 1024;
            $uploadField->getValidator()->setAllowedMaxFileSize($size);
            $uploadField->setDescription(_t(__CLASS__ . '.ImageDescription', 'MP4 16:9 web optimized!'));
        }

        if ($autoplayField = $fields->dataFieldByName('Autoplay')) {
            $fields->insertAfter('LocalMP4Video', $autoplayField);
        }

        if ($loopField = $fields->dataFieldByName('Loop')) {
            $fields->insertAfter('Autoplay', $loopField);
        }

        if ($muteField = $fields->dataFieldByName('Mute')) {
            $fields->insertAfter('Loop', $muteField);
        }

        return $fields;
    }

    protected function provideBlockSchema()
    {
        $blockSchema = parent::provideBlockSchema();
        if ($this->Image()->exists()) {
            $blockSchema['fileURL'] = $this->Image->CMSThumbnail()->getURL();
        }
        return $blockSchema;
    }

    public function getType()
    {
        return _t(__CLASS__ . '.BlockType', 'Local Video');
    }
}
