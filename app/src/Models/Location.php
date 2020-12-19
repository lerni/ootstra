<?php

namespace App\Models;

use BetterBrief\GoogleMapField;
use SilverStripe\Core\Config\Config;
use SilverStripe\Forms\DropdownField;
use SilverStripe\i18n\i18n;
use SilverStripe\ORM\DataObject;
use SilverStripe\SiteConfig\SiteConfig;

class Location extends DataObject
{
    private static $db = [
        'Title' => 'Varchar',
        'Address' => 'Varchar',
        'PostOfficeBoxNumber' => 'Varchar',
        'PostalCode' => 'Varchar(32)',
        'Town' => 'Varchar',
        'Country' => 'Varchar(16)',
        'Telephone' => 'Varchar',
        'AddressRegion' => 'Varchar',
        'EMail' => 'Varchar',
        'OpeningHours' => 'Text',
        'Sort' => 'Int'
    ];

    private static $has_one = [
        'SiteConfig' => SiteConfig::class,
        'GeoPoint' => Point::class
    ];
    private static $belongs_many_many = [];

    private static $table_name = 'Location';
    private static $default_sort = 'Sort ASC';

    private static $singular_name = 'Location';
    private static $plural_name = 'Locations';

    private static $field_labels = [
        'Address' => 'Adresse',
        'PostOfficeBoxNumber' => 'Postfach',
        'PostalCode' => 'PLZ',
        'Town' => 'Ort',
        'AddressRegion' => 'Kanton',
        'Telephone' => 'Telefon',
        'EMail' => 'E-Mail',
        'GeoPoint' => 'Koordinaten'
    ];
    public function fieldLabels($includerelations = true)
    {
        $labels = parent::fieldLabels($includerelations);
        $labels['Address'] = _t(__CLASS__ . '.ADDRESS', 'Adresse');
        $labels['PostOfficeBoxNumber'] = _t(__CLASS__ . '.POSTOFFICEBOXNUMBER', 'Postfach');
        $labels['PostalCode'] = _t(__CLASS__ . '.POSTALCODE', 'PLZ');
        $labels['Town'] = _t(__CLASS__ . '.TOWN', 'Ort');
        $labels['AddressRegion'] = _t(__CLASS__ . '.ADDRESSREGION', 'Kanton');
        $labels['Telephone'] = _t(__CLASS__ . '.TELEPHONE', 'Telefon');
        $labels['EMail'] = _t(__CLASS__ . '.EMAIL', 'E-Mail');
        $labels['GeoPoint'] = _t(__CLASS__ . '.GEOPOINT', 'Koordinaten');

        return $labels;
    }

    private static $summary_fields = [
        'Title' => 'Titel',
        'Address' => 'Adresse',
        'Town' => 'Ort',
        'Telephone' => 'Telefon',
    ];

    private static $searchable_fields = [
        'Title',
        'Town'
    ];

    private static $translate = [
        'Title'
    ];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->removeByName('Sort');
        $fields->removeByName('SiteConfigID');

        $gmapDefaultConfig = Config::inst()->get(GoogleMapField::class, 'default_options');
        if (isset($gmapDefaultConfig['api_key']) && $GeoPointField = $fields->dataFieldByName('GeoPointID')) {
            $GeoPointField->setDescription('Geokoordinaten vom ElementMap mit Location assozieren');
        }

        $ContryDropdownField = DropdownField::create('Country', 'Country');
        $ContryDropdownField->setSource(i18n::getData()->getCountries());
        $ContryDropdownField->setEmptyString('--');
        $fields->replaceField('Country', $ContryDropdownField);

        return $fields;
    }
}
