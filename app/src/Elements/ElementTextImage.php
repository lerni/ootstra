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

    private static $field_labels = [
        'HTML' => 'Text',
        'Image' => 'Bild',
        'ElementLayout' => 'Anordnung links...'
    ];

    private static $owns = [
        'Image'
    ];

    private static $table_name = 'ElementTextImage';

    private static $title = 'TextImage Element';

    private static $inline_editable = false;

    function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->removeByName('BackgroundColor');

        if ($TextEditorField = $fields->dataFieldByName('HTML')) {
            $TextEditorField->addExtraClass('stacked');
        }

        if ($uploadField = $fields->dataFieldByName('Image')) {
            $uploadField->setFolderName('TextImageElement');
            $uploadField->setDescription('min. 1400x1800px');
        }

        if ($CoverField = $fields->dataFieldByName('ImageCover')) {
            $fields->addFieldToTab('Root.Main', $CoverField, 'Image');
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
        return _t(__CLASS__ . '.BlockType', 'false');
    }
}
