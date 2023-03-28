<?php

namespace App\Elements;

use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\Assets\Image;
use SilverStripe\ORM\FieldType\DBHTMLText;

class ElementTextImage extends BaseElement
{
    private static $db = [
        'HTML' => 'HTMLText',
        'ElementLayout' => 'Enum("Image, Text", "Image")',
        'ImageCover' => 'Boolean'
    ];

    private static $has_one = [
        'Image' => Image::class
    ];

    private static $has_many = [];

    private static $many_many = [];

    private static $owns = [
        'Image'
    ];

    private static $table_name = 'ElementTextImage';

    private static $title = 'TextImage Element';

    private static $icon = 'font-icon-block-layout-8';

    public function fieldLabels($includerelations = true)
    {
        $labels = parent::fieldLabels($includerelations);
        $labels['HTML'] = _t(__CLASS__ . '.HTML', 'Text');
        $labels['Image'] = _t(__CLASS__ . '.IMAGE', 'Image');
        $labels['ElementLayout'] = _t(__CLASS__ . '.ELEMENTLAYOUT', 'Arrangement left...');
        return $labels;
    }

    function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->removeByName([
            'BackgroundColor'
        ]);

        if ($uploadField = $fields->dataFieldByName('Image')) {
            $uploadField->setFolderName('TextImageElement');
            $size = 5 * 1024 * 1024;
            $uploadField->getValidator()->setAllowedMaxFileSize($size);
            $uploadField->setDescription(_t(__CLASS__ . '.ImageDescription', 'min. 1400x1800px'));
        }

        if ($CoverField = $fields->dataFieldByName('ImageCover')) {
            $fields->addFieldToTab('Root.Main', $CoverField, 'Image');
        }

        if ($TextEditor = $fields->dataFieldByName('HTML')) {
            $TextEditor->setAttribute('data-mce-body-class', $this->owner->ShortClassName('true') . ' background--' . $this->BackgroundColor);
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
        return _t(__CLASS__ . '.BlockType', 'Text Image');
    }
}
