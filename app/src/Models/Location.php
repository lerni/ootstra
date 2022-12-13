<?php

namespace App\Models;

use App\Models\Point;
use SilverStripe\i18n\i18n;
use BetterBrief\GoogleMapField;
use SilverStripe\ORM\DataObject;
use SilverStripe\Core\Config\Config;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\RequiredFields;
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

    public function fieldLabels($includerelations = true)
    {
        $labels = parent::fieldLabels($includerelations);
        $labels['Title'] = _t(__CLASS__ . '.TITLE', 'Title');
        $labels['Address'] = _t(__CLASS__ . '.ADDRESS', 'Address');
        $labels['PostOfficeBoxNumber'] = _t(__CLASS__ . '.POSTOFFICEBOXNUMBER', 'P.O. Box');
        $labels['PostalCode'] = _t(__CLASS__ . '.POSTALCODE', 'Postcode');
        $labels['Town'] = _t(__CLASS__ . '.TOWN', 'Town');
        $labels['AddressRegion'] = _t(__CLASS__ . '.ADDRESSREGION', 'Canton/State');
        $labels['Telephone'] = _t(__CLASS__ . '.TELEPHONE', 'Phone');
        $labels['EMail'] = _t(__CLASS__ . '.EMAIL', 'E-Mail');
        $labels['OpeningHours'] = _t(__CLASS__ . '.OPENINGHOURS', 'Opening hours');
        $labels['GeoPoint'] = _t(__CLASS__ . '.GEOPOINT', 'Coordinates');

        return $labels;
    }

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->removeByName([
            'Sort',
            'SiteConfigID'
        ]);

        $gmapDefaultConfig = Config::inst()->get(GoogleMapField::class, 'default_options');
        if (isset($gmapDefaultConfig['api_key']) && $GeoPointField = $fields->dataFieldByName('GeoPointID')) {
            $GeoPointField->setDescription(_t(__CLASS__ . '.DescriptionGeoPointField', 'Link coordinates from ElementMap'));
        }

        $ContryDropdownField = DropdownField::create('Country', _t(__CLASS__ . '.COUNTRY', 'Country'));
        $ContryDropdownField->setSource(i18n::getData()->getCountries());
        $ContryDropdownField->setEmptyString('--');
        $fields->replaceField('Country', $ContryDropdownField);

        return $fields;
    }

    public function getCMSValidator()
    {
        return new RequiredFields([
            'Title',
            'Town'
        ]);
    }
}
