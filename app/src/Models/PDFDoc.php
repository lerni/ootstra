<?php

namespace App\Models;

use SilverStripe\Assets\File;
use SilverStripe\Assets\Image;
use SilverStripe\ORM\DataObject;
use App\Elements\ElementPDFDocument;
use SilverStripe\Forms\TextareaField;

class PDFDoc extends DataObject
{
    private static $db = [
        'Title' => 'Varchar',
        'Text' => 'Text',
        'SortOrder' => 'Int'
    ];

    private static $has_one = [
        'Image' => Image::class,
        'Document' => File::class,
    ];

    private static $owns = [
        'Image',
        'Document'
    ];

    private static $belongs_many_many = [
        'ElementPDFDocuments' => ElementPDFDocument::class
    ];

    private static $summary_fields = [
        'ImageWithFallback.CMSThumbnail' => 'Thumbnail',
        'Title' => 'Titel',
        'Text' => 'Text'
    ];

    private static $searchable_fields = [
        'Title',
        'Text'
    ];

    private static $field_labels = [
        'Title' => 'Titel'
    ];

    private static $table_name = 'PDFDoc';

    public function getCMSFields()
    {

        $fields = parent::getCMSFields();
        $fields->removeByName([
            'SortOrder'
        ]);

        $TitleAreaField = TextareaField::create('Title', 'Titel');
        $TitleAreaField->setRows(3);
        $fields->replaceField('Title', $TitleAreaField);

        if ($uploadField = $fields->dataFieldByName('Image')) {
            $uploadField->setAllowedExtensions(['jpg', 'png']);
            $uploadField->setFolderName('Dokumente/PDF');
            $uploadField->setDescription('nur Bilder (randlos, kein Titel etc.) als jpg oder png, Proportion ~1:1.45');
        }

        if ($docuploadField = $fields->dataFieldByName('Document')) {
            $docuploadField->setFolderName('Dokumente/PDF');
            $docuploadField->setAllowedExtensions(['pdf']);
            $size = 20 * 1024 * 1024;
            $docuploadField->getValidator()->setAllowedMaxFileSize($size);
            $docuploadField->setDescription('Nur PDF-Dateien sind erlaubt.');
        }

        return $fields;
    }

    // should we hate magic getters?
    public function ImageWithFallback()
    {
        $img = null;
        if ($this->Image()->exists()) {
            $img = $this->Image();
        } elseif ($this->Document()->exists()){
            $img = $this->Document()->PDFImage();
        }
        return $img;
    }
}
