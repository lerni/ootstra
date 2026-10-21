<?php

namespace App\Models;

use App\Models\Point;
use App\Models\Vacation;
use App\Models\OpeningHour;
use SilverStripe\i18n\i18n;
use Spatie\SchemaOrg\Schema;
use SilverStripe\Core\Convert;
use BetterBrief\GoogleMapField;
use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\TimeField;
use SilverStripe\Core\Config\Config;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig;
use SilverStripe\Core\Validation\ValidationResult;
use SilverStripe\Forms\GridField\GridFieldButtonRow;
use SilverStripe\Forms\Validation\CompositeValidator;
use Symbiote\GridFieldExtensions\GridFieldTitleHeader;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use SilverStripe\Forms\Validation\RequiredFieldsValidator;
use Symbiote\GridFieldExtensions\GridFieldEditableColumns;
use Symbiote\GridFieldExtensions\GridFieldAddNewInlineButton;

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
        'OpeningHours' => 'Text', // todo: remove once legacy opening hours are fully migrated
        'Sort' => 'Int',
    ];

    private static $has_one = [
        'SiteConfig' => SiteConfig::class,
        'GeoPoint' => Point::class,
    ];

    private static $has_many = [
        'OpeningTimes' => OpeningHour::class,
    ];

    private static $cascade_deletes = [
        'OpeningTimes',
    ];

    private static $belongs_many_many = [
        'Vacations' => Vacation::class,
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
        $labels['OpeningHours'] = _t(self::class . '.OPENINGHOURS', 'Opening hours (free text, legacy)');
        $labels['OpeningTimes'] = _t(self::class . '.OPENINGTIMES', 'Opening hours');
        $labels['GeoPoint'] = _t(self::class . '.GEOPOINT', 'Coordinates');

        return $labels;
    }

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->removeByName([
            'Sort',
            'SiteConfigID',
            'Vacations',
        ]);

        $gmapDefaultConfig = Config::inst()->get(GoogleMapField::class, 'default_options');
        if (isset($gmapDefaultConfig['api_key']) && $GeoPointField = $fields->dataFieldByName('GeoPointID')) {
            $GeoPointField->setDescription(_t(self::class . '.DescriptionGeoPointField', 'Link coordinates from ElementMap'));
        }

        $ContryDropdownField = DropdownField::create('Country', _t(self::class . '.COUNTRY', 'Country'));
        $ContryDropdownField->setSource(i18n::getData()->getCountries());
        $ContryDropdownField->setEmptyString('--');
        $fields->replaceField('Country', $ContryDropdownField);

        $this->addOpeningTimesFields($fields);

        $dbFields = $this->config()->get('db');
        foreach ($dbFields as $fieldName => $fieldType) {
            if ($field = $fields->dataFieldByName($fieldName)) {
                $field->setDescription('<p>[Location Title="' . $this->Title . '" Field="' . $fieldName . '"]</p>');
            }
        }

        return $fields;
    }

    protected function addOpeningTimesFields(FieldList $fields): void
    {
        // The free text field is only kept for existing content, it's not used for schema.org output
        if ($this->OpeningHours) {
            if ($legacyField = $fields->dataFieldByName('OpeningHours')) {
                $legacyField->setDescription(_t(self::class . '.OPENINGHOURSLEGACY', 'Not used for structured data. Replaced by the structured opening hours below.'));
            }
        } else {
            $fields->removeByName('OpeningHours');
        }

        $fields->removeByName('OpeningTimes');
        if (!$this->exists()) {
            $fields->addFieldToTab('Root.Main', LiteralField::create(
                'OpeningTimesNotice',
                '<p class="message notice">' . _t(self::class . '.OPENINGTIMESSAVEFIRST', 'Save the location first to add opening hours.') . '</p>',
            ));

            return;
        }

        $days = OpeningHour::dayOptions();
        $config = GridFieldConfig::create()->addComponents(
            GridFieldButtonRow::create('before'),
            GridFieldTitleHeader::create(),
            GridFieldEditableColumns::create()->setDisplayFields([
                'DayFrom' => ['title' => $this->OpeningHourLabel('DayFrom'), 'callback' => fn () => DropdownField::create('DayFrom', '', $days)->setAttribute('style', 'min-width: 9em')],
                'DayTo' => ['title' => $this->OpeningHourLabel('DayTo'), 'callback' => fn () => DropdownField::create('DayTo', '', $days)->setEmptyString('–')->setAttribute('style', 'min-width: 9em')],
                'Opens' => ['title' => $this->OpeningHourLabel('Opens'), 'callback' => fn () => TimeField::create('Opens', '')->setAttribute('step', 60)],
                'Closes' => ['title' => $this->OpeningHourLabel('Closes'), 'callback' => fn () => TimeField::create('Closes', '')->setAttribute('step', 60)],
                'Note' => ['title' => $this->OpeningHourLabel('Note'), 'callback' => fn () => TextField::create('Note', '')->setAttribute('style', 'min-width: 14em')],
            ]),
            GridFieldAddNewInlineButton::create('buttons-before-left')->setTitle(_t(self::class . '.ADDOPENINGTIME', 'Add opening hours')),
            GridFieldDeleteAction::create(),
            GridFieldOrderableRows::create('Sort'),
        );
        $grid = GridField::create('OpeningTimes', $this->fieldLabel('OpeningTimes'), $this->OpeningTimes(), $config);
        $grid->setDescription(
            '<p>[Location Title="' . Convert::raw2xml($this->Title) . '" Field="OpeningHours"]</p>' . _t(self::class . '.OPENINGTIMESDESCRIPTION', 'One row per time range, e.g. a lunch break means two rows. Leave times empty to mark days as closed. Holidays are managed under "Vacations & Holidays".'),
        );
        $fields->addFieldToTab('Root.Main', $grid);
    }

    protected function OpeningHourLabel(string $field): string
    {
        return OpeningHour::singleton()->fieldLabel($field);
    }

    /**
     * Opening hours as escaped HTML, one line per day span with its time ranges combined,
     * e.g. "Mon – Fri: 08:00 – 12:00 and 13:30 – 17:00"; null if none are maintained.
     */
    public function OpeningHoursHTML(): ?string
    {
        $groups = [];
        foreach ($this->OpeningTimes() as $range) {
            $key = $range->DayFrom . '|' . $range->DayTo;
            $groups[$key]['days'] ??= $range->getDayLabel(true);
            $time = Convert::raw2xml($range->getTimeLabel());
            $groups[$key]['times'][] = $time;
            $groups[$key]['closed'] = ($groups[$key]['closed'] ?? false) || $range->isClosed();
        }

        $suffix = _t(self::class . '.OPENINGHOURSSUFFIX', '');
        $and = ' ' . _t(self::class . '.OPENINGHOURSAND', 'and') . ' ';
        $lines = [];
        foreach ($groups as $group) {
            $lines[] = Convert::raw2xml($group['days']) . ': ' . implode($and, $group['times']) . ($group['closed'] ? '' : $suffix);
        }

        return $lines ? implode('<br>', $lines) : null;
    }

    /**
     * schema.org OpeningHoursSpecification list: regular hours plus one closure per current or upcoming Vacation.
     *
     * @return \Spatie\SchemaOrg\OpeningHoursSpecification[]
     */
    public function OpeningHoursSpecifications(): array
    {
        $specs = [];
        foreach ($this->OpeningTimes() as $range) {
            if ($spec = $range->toSchema()) {
                $specs[] = $spec;
            }
        }

        // Closures without regular hours would be meaningless
        if (!$specs) {
            return [];
        }

        // A closure is an all-day range (00:00 - 00:00) limited by validFrom/validThrough
        $today = date('Y-m-d');
        foreach ($this->Vacations()->filter('EndDate:GreaterThanOrEqual', $today)->sort('StartDate ASC') as $vacation) {
            $specs[] = Schema::openingHoursSpecification()
                ->opens('00:00')
                ->closes('00:00')
                ->validFrom($vacation->StartDate)
                ->validThrough($vacation->EndDate);
        }

        return $specs;
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
