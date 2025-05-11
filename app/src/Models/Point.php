<?php

namespace App\Models;

use BetterBrief\GoogleMapField;
use SilverStripe\ORM\DataObject;
use SilverStripe\Core\Environment;
use SilverStripe\Core\Config\Config;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\ORM\FieldType\DBHTMLText;

class Point extends DataObject
{
    private static $db = [
        'Latitude' => 'Decimal(18,15)',
        'Longitude' => 'Decimal(18,15)',
        'Title' => 'Varchar',
        'PointURL' => 'Varchar',
        'Type' => 'Enum("normal, parking", "normal")'
    ];

    private static $has_one = [];

    private static $table_name = 'Point';

    private static $singular_name = 'Point';
    private static $plural_name = 'Points';

    private static $summary_fields = [
        'getThunbnail' => 'Thumbnail',
        'Title' => 'Titel',
        'Type' => 'Type'
    ];

    private static $searchable_fields = [
        'Title'
    ];

    public function fieldLabels($includerelations = true)
    {
        $labels = parent::fieldLabels($includerelations);
        $labels['Title'] = _t(__CLASS__ . '.TITLE', 'Titel');
        $labels['PointURL'] = _t(__CLASS__ . '.POINTURL', 'Link on marker');

        return $labels;
    }

    public function getCMSFields()
    {

        $fields = parent::getCMSFields();

        if ($PointURLField = $fields->dataFieldByName('PointURL')) {
            $PointURLField->setDescription(_t(__CLASS__ . '.PointURLDESCRIPTION', 'Link to business entry from Google-Map'));
        }

        $fields->removeByName([
            'Latitude',
            'Longitude'
        ]);

        $googleMapField = GoogleMapField::create($this, 'Google-Map');
        $fields->addFieldToTab('Root.Main', $googleMapField);

        return $fields;
    }

    // todo api-key is needed so we should return a default thumb if no API-key
    public function getThunbnail()
    {
        $url =  'https://maps.googleapis.com/maps/api/staticmap?center=' . $this->Latitude . ',' . $this->Longitude . '&zoom=16&size=140x140&maptype=hybrid&markers=color:red%7C' . $this->Latitude . ',' . $this->Longitude;
        $key = Environment::getEnv('APP_GOOGLE_MAPS_KEY') ?: Config::inst()->get(GoogleMapField::class, 'api_key');
        if ($key) {
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

    public function getCMSValidator()
    {
        return new RequiredFields([
            'Title'
        ]);
    }
}
