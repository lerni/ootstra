<?php

namespace App\Models;

use SilverStripe\Assets\Image;
use SilverStripe\ORM\DataObject;

class Logo extends DataObject
{
    private static $db = [
        'Title' => 'Varchar',
        'Link' => 'Varchar'
    ];

    private static $has_one = [
        'LogoImage' => Image::class
    ];

    private static $many_many = [];

    private static $owns = [
        'LogoImage'
    ];

    private static $summary_fields = [
        'LogoImage.CMSThumbnail' => 'Thumbnail',
        'Title' => 'Titel',
        'Link' => 'Link'
    ];

    private static $field_labels = [
        'Title' => 'Titel'
    ];

    private static $table_name = 'Logo';

    private static $default_sort = 'Title ASC';

    public function getCMSFields()
    {

        $fields = parent::getCMSFields();

        if ($uploadField = $fields->dataFieldByName('LogoImage')) {
            $uploadField->setFolderName('Logos');
            $uploadField->setDescription('min. 120px hoch');
        }

        return $fields;
    }
}
