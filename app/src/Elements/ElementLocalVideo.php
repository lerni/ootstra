<?php

namespace App\Elements;

use SilverStripe\Assets\File;
use SilverStripe\Assets\Image;
use DNADesign\Elemental\Models\BaseElement;

class ElementLocalVideo extends BaseElement
{
    private static $db = [
        'Autoplay' => 'Boolean',
        'Loop' => 'Boolean',
        'Mute' => 'Boolean',
    ];

    private static $has_one = [
        'Image' => Image::class,
        'LocalVideo' => File::class,
        'LocalVideoSmall' => File::class,
    ];

    private static $has_many = [];

    private static $many_many = [];

    private static $owns = [
        'Image',
        'LocalVideo',
        'LocalVideoSmall',
    ];

    private static $table_name = 'ElementLocalVideo';

    private static $title = 'Local video element';

    private static $icon = 'font-icon-block-video';

    public function fieldLabels($includerelations = true)
    {
        $labels = parent::fieldLabels($includerelations);
        $labels['Image'] = _t(self::class . '.IMAGE', 'Poster/still image');
        $labels['Autoplay'] = _t(self::class . '.AUTOPLAY', 'Autoplay - enforces "Mute"');
        $labels['Loop'] = _t(self::class . '.LOOP', 'Looping video');
        $labels['Mute'] = _t(self::class . '.MUTE', 'Mute initial state');

        return $labels;
    }

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        if ($uploadField = $fields->dataFieldByName('Image')) {
            $uploadField->setFolderName('Video');
            $uploadField->setDescription(_t(self::class . '.ImageDescription', '16:9'));
        }

        if ($uploadField = $fields->dataFieldByName('LocalVideo')) {
            $uploadField->setFolderName('Video');
            $uploadField->allowedExtensions = ['webm', 'mp4'];
            $size = 50 * 1024 * 1024;
            $uploadField->getValidator()->setAllowedMaxFileSize($size);
            $uploadField->setDescription(_t(self::class . '.LocalVideoDescription', 'MP4/Webm 16:9 web optimized!'));
        }

        if ($uploadField = $fields->dataFieldByName('LocalVideoSmall')) {
            $uploadField->setFolderName('Video');
            $uploadField->allowedExtensions = ['webm', 'mp4'];
            $size = 20 * 1024 * 1024;
            $uploadField->getValidator()->setAllowedMaxFileSize($size);
            $uploadField->setDescription(_t(self::class . '.LocalVideoSmallDescription', 'MP4/Webm 16:9 web optimized! < 800px wide'));
        }

        if ($autoplayField = $fields->dataFieldByName('Autoplay')) {
            $fields->insertAfter('LocalVideoSmall', $autoplayField);
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
        return _t(self::class . '.BlockType', 'Local Video');
    }
}
