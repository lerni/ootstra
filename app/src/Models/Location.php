<?php

namespace App\Models;

use App\Models\Point;
use SilverStripe\i18n\i18n;
use BetterBrief\GoogleMapField;
use SilverStripe\ORM\DataObject;
use SilverStripe\Core\Config\Config;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\TextareaField;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\Core\Validation\ValidationResult;
use SilverStripe\Forms\Validation\CompositeValidator;
use SilverStripe\Forms\Validation\RequiredFieldsValidator;

class Location extends DataObject
{
    private static $db = [
        'Title' => 'Varchar',
        'Address' => 'Varchar',
        'PostOfficeBoxNumber' => 'Varchar(32)',
        'PostalCode' => 'Varchar(32)',
        'Town' => 'Varchar',
        'Country' => 'Varchar(16)',
        'Telephone' => 'Varchar',
        'AddressRegion' => 'Varchar',
        'EMail' => 'Varchar',
        'Sort' => 'Int',
    ];

    private static $has_one = [
        'SiteConfig' => SiteConfig::class,
        'GeoPoint' => Point::class,
    ];

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

    private static $indexes = [
        'Title' => [
            'type' => 'unique',
            'columns' => ['Title'],
        ],
    ];

    private static $translate = [
        'Title',
    ];

    public function singular_name()
    {
        return _t(self::class . '.SINGULARNAME', 'Location');
    }

    public function plural_name()
    {
        return _t(self::class . '.PLURALNAME', 'Locations');
    }

    public function fieldLabels($includerelations = true)
    {
        $labels = parent::fieldLabels($includerelations);
        $labels['Title'] = _t(self::class . '.TITLE', 'Title');
        $labels['Address'] = _t(self::class . '.ADDRESS', 'Address');
        $labels['PostOfficeBoxNumber'] = _t(self::class . '.POSTOFFICEBOXNUMBER', 'P.O. Box');
        $labels['PostalCode'] = _t(self::class . '.POSTALCODE', 'Postcode');
        $labels['Town'] = _t(self::class . '.TOWN', 'Town');
        $labels['AddressRegion'] = _t(self::class . '.ADDRESSREGION', 'Canton/State');
        $labels['Telephone'] = _t(self::class . '.TELEPHONE', 'Phone');
        $labels['EMail'] = _t(self::class . '.EMAIL', 'E-Mail');
        $labels['GeoPoint'] = _t(self::class . '.GEOPOINT', 'Coordinates');

        return $labels;
    }

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->removeByName([
            'Sort',
            'SiteConfigID',
        ]);

        $gmapDefaultConfig = Config::inst()->get(GoogleMapField::class, 'default_options');
        if (isset($gmapDefaultConfig['api_key']) && $GeoPointField = $fields->dataFieldByName('GeoPointID')) {
            $GeoPointField->setDescription(_t(self::class . '.DescriptionGeoPointField', 'Link coordinates from ElementMap'));
        }

        $ContryDropdownField = DropdownField::create('Country', _t(self::class . '.COUNTRY', 'Country'));
        $ContryDropdownField->setSource(i18n::getData()->getCountries());
        $ContryDropdownField->setEmptyString('--');
        $fields->replaceField('Country', $ContryDropdownField);

        $dbFields = $this->config()->get('db');
        foreach ($dbFields as $fieldName => $fieldType) {
            if ($field = $fields->dataFieldByName($fieldName)) {
                $field->setDescription('<p>[Location ID="' . $this->ID . '" Field="' . $fieldName . '"]</p>');
            }
        }

        if ($this->exists()) {
            $fields->addFieldToTab('Root.Main', $this->getShortCodeBlockField());
        }

        return $fields;
    }

    protected function getShortCodeBlockField(): TextareaField
    {
        $code = fn (string $field) => '[Location ID="' . $this->ID . '" Field="' . $field . '"]';
        $block = implode("\n", [
            $code('Title'),
            $code('Address'),
            $code('PostalCode') . ' ' . $code('Town'),
            '',
            $code('TelLink'),
            '',
            $code('EMailLink'),
        ]);

        return TextareaField::create('ShortCodeBlock', _t(self::class . '.SHORTCODEBLOCK', 'Shortcodes address block'), $block)
            ->setRows(8)
            ->setReadonly(true)
            ->setDescription(_t(self::class . '.SHORTCODEBLOCKDESCRIPTION', 'Copy into any text to show title, address, phone and e-mail of this location.'));
    }

    // this needs "wnx/php-swiss-cantons": "^4", in composer.json
    // function Canton() {
    //     $base = Director::baseFolder();
    //     $zipcodes = json_decode(file_get_contents($base . '/vendor/wnx/php-swiss-cantons/src/data/zipcodes.json'), true);
    //     $cantons = json_decode(file_get_contents($base . '/vendor/wnx/php-swiss-cantons/src/data/cantons.json'), true);

    //     foreach ($zipcodes as $zipcode) {
    //         if ($zipcode['city'] == $this->Town) {
    //             foreach ($cantons as $canton) {
    //                 if ($canton['abbreviation'] == $zipcode['canton']) {
    //                     return $canton['name']['de'];
    //                 }
    //             }
    //         }
    //     }
    //     return null;
    // }

    public function CountryCodeUppercase()
    {
        return strtoupper($this->Country);
    }

    public function CountryName(): ?string
    {
        return $this->Country ? i18n::getData()->countryName($this->Country) : null;
    }

    public function getCMSCompositeValidator(): CompositeValidator
    {
        $validator = parent::getCMSCompositeValidator();
        $validator->addValidator(
            RequiredFieldsValidator::create([
                'Title',
                'Town',
            ]),
        );

        return $validator;
    }

    public function validate(): ValidationResult
    {
        $result = parent::validate();

        if (static::get()->filter(['Title' => $this->Title])->exclude(['ID' => $this->ID])->count() > 0) {
            $result->addError(_t(self::class . '.Duplicate', '{FieldName} must be unique', ['FieldName' => 'Title']));
        }

        return $result;
    }
}
