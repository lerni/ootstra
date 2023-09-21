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
        'LogoImage.PreviewThumbnail' => 'Thumbnail',
        'Title' => 'Titel',
        'Link' => 'Link'
    ];

    private static $table_name = 'Logo';

    private static $default_sort = 'Title ASC';

    public function fieldLabels($includerelations = true)
    {
        $labels = parent::fieldLabels($includerelations);
        $labels['Title'] = _t(__CLASS__ . '.TITLE', 'Titel');

        return $labels;
    }

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        if ($uploadField = $fields->dataFieldByName('LogoImage')) {
            $uploadField->setFolderName('Logos');
            $size = 5 * 1024 * 1024;
            $uploadField->getValidator()->setAllowedMaxFileSize($size);
            $uploadField->setDescription(_t(__CLASS__ . '.LogoImageDescription', 'min. 120px height'));
        }

        return $fields;
    }
}
