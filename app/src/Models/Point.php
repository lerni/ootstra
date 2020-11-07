<?php

namespace App\Models;

use BetterBrief\GoogleMapField;
use SilverStripe\ORM\DataObject;
use SilverStripe\Core\Config\Config;
use SilverStripe\ORM\FieldType\DBHTMLText;

class Point extends DataObject
{
    private static $db = [
        'Latitude' => 'Decimal(18,15)',
        'Longitude' => 'Decimal(18,15)',
        'Title' => 'Varchar',
        'PointURL' => 'Varchar'
    ];

    private static $has_one = [];

    private static $table_name = 'Point';

    private static $singular_name = 'Point';
    private static $plural_name = 'Points';

    private static $summary_fields = [
        'getThunbnail' => 'Thumbnail',
        'Title' => 'Titel'
    ];

    private static $field_labels = [
        'Title' => 'Titel',
        'PointURL' => 'Link auf Marker'
    ];

    private static $searchable_fields = [
        'Title'
    ];

    public function getCMSFields()
    {

        $fields = parent::getCMSFields();

        if ($PointURLField = $fields->dataFieldByName('PointURL')) {
            $PointURLField->setDescription('Link (Kurzform) auf Business-Eintrag von Google-Map');
        }

        $fields->removeByName('Latitude');
        $fields->removeByName('Longitude');
        $googleMapField = GoogleMapField::create($this, 'Google-Map');
        $fields->addFieldToTab('Root.Main', $googleMapField);

        return $fields;
    }

    // todo api-key is needed so we should return a default thumb if no API-key
    public function getThunbnail()
    {
        $url =  'https://maps.googleapis.com/maps/api/staticmap?center=' . $this->Latitude . ',' . $this->Longitude . '&zoom=16&size=140x140&maptype=hybrid&markers=color:red%7C' . $this->Latitude . ',' . $this->Longitude;
        $gmapDefaultConfig = Config::inst()->get(GoogleMapField::class, 'default_options');
        if (isset($gmapDefaultConfig['api_key'])) {
            $key = $gmapDefaultConfig['api_key'];
            $url = $url . '&key=' . $key;
        }
        $tag = '<img src="' . $url . '" title="' . $this->Title . '">';
        $obj = DBHTMLText::create();
        $obj->setValue($tag);
        return ($obj);
    }

    public function GMapLatLngLink()
    {
        $link = $this->PointURL;
        if (!$link && $this->Latitude && $this->Longitude) {
            $link = 'https://www.google.ch/maps/place/' . $this->Latitude . ',' . $this->Longitude . '/@' . $this->Latitude . ',' . $this->Longitude . ',18z/data=!3m1!1e3!';
        }
        return $link;
    }

    public function canView($member = null)
    {
        return true;
    }
}
