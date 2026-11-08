<?php

namespace App\Extensions;

use App\Models\Slide;
use App\Models\Location;
use App\Models\Vacation;
use App\Models\SocialLink;
use App\Models\OpeningHour;
use SilverStripe\Forms\Tab;
use SilverStripe\i18n\i18n;
use Spatie\SchemaOrg\Schema;
use App\Schema\SchemaBuilder;
use SilverStripe\Core\Convert;
use App\Models\ShortCodeSnippet;
use SilverStripe\Core\Extension;
use SilverStripe\Forms\DateField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\TimeField;
use SilverStripe\Forms\HeaderField;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\TextareaField;
use SilverStripe\ORM\FieldType\DBDate;
use SilverStripe\LinkField\Models\Link;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\Forms\GridField\GridField;
use App\GridField\GridFieldConfig_OwnRecords;
use SilverStripe\LinkField\Form\MultiLinkField;
use SilverStripe\Forms\GridField\GridFieldConfig;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use App\GridField\GridFieldConfig_SortableRelation;
use SilverStripe\Forms\GridField\GridFieldButtonRow;
use Symbiote\GridFieldExtensions\GridFieldTitleHeader;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use Symbiote\GridFieldExtensions\GridFieldEditableColumns;
use Symbiote\GridFieldExtensions\GridFieldAddNewInlineButton;

/**
 * @extends Extension<SiteConfig>
 */
class SiteConfigExtension extends Extension
{
    private static $db = [
        'MetaDescription' => 'Varchar',
        'legalName' => 'Varchar',
        'foundingDate' => DBDate::class,
        'GlobalAlert' => 'HTMLText',
        'DefaultHeroSize' => 'Enum("small,medium","small")',
        'SchemaType' => 'Varchar',
    ];

    private static $has_one = [];

    private static $has_many = [
        'Locations' => Location::class,
        'ServiceNavigationItems' => Link::class . '.Owner',
        'TermsNavigationItems' => Link::class . '.Owner',
        'OpeningHours' => OpeningHour::class,
        'Vacations' => Vacation::class,
    ];

    private static $casting = [
        'OpeningHoursHTML' => 'HTMLFragment',
    ];

    private static $many_many = [
        'SocialLinks' => SocialLink::class,
        'DefaultHeaderSlides' => Slide::class,
    ];

    private static $many_many_extraFields = [
        'SocialLinks' => [
            'SortOrder' => 'Int',
        ],
        'DefaultHeaderSlides' => [
            'SortOrder' => 'Int',
        ],
    ];

    private static $owns = [
        'DefaultHeaderSlides',
        'ServiceNavigationItems',
        'TermsNavigationItems',
    ];

    private static $translate = [
        'Title',
        'MetaDescription',
    ];

    public function updateCMSFields(FieldList $fields)
    {
        $fields->removeByName([
            'Tagline',
        ]);

        $fields->renameField('Title', _t('SilverStripe\SiteConfig\SiteConfig.TITLE', 'Title / Name'));

        $fields->addFieldToTab('Root.Main', $legalNameField = TextField::create('legalName', _t('SilverStripe\SiteConfig\SiteConfig.LEGALNAME', 'Official name (legal)')));
        $fields->addFieldToTab('Root.Main', $foundingDateField = DateField::create('foundingDate', _t('SilverStripe\SiteConfig\SiteConfig.FOUNDINGDATE', 'Date of foundation'))->setHTML5(true));

        $schemaTypeKeys = array_keys(SchemaBuilder::availableTypes());
        $schemaTypes = array_combine($schemaTypeKeys, $schemaTypeKeys);
        $fields->addFieldToTab('Root.Main', $schmeTypeField = DropdownField::create('SchemaType', _t('SilverStripe\SiteConfig\SiteConfig.SCHEMATYPE', 'Schema Type'), $schemaTypes));

        $fields->addFieldToTab('Root.Main', HeaderField::create('MetaData', 'Meta Daten'));
        $fields->addFieldToTab('Root.Main', $MetaDescriptionField = TextareaField::create('MetaDescription', _t('SilverStripe\SiteConfig\SiteConfig.METADESCRIPTION', 'Meta Description')));
        $MetaDescriptionField->setTargetLength(150, 100, 160);
        $MetaDescriptionField->setDescription(_t('SilverStripe\SiteConfig\SiteConfig.MetaDescriptionDescription', 'Default value if no description is present at page level.'));

        $fields->addFieldsToTab('Root.Main', [$GlobalAlertField = HTMLEditorField::create('GlobalAlert')]);
        $GlobalAlertField->setRows(14);
        $GlobalAlertField->setEditorConfig('inlite'); // we need to use a different config, otherwise the "body_class" is overwritten also for editors with bigfork/silverstripe-fail-whale
        $GlobalAlertField->getEditorConfig()->setOption('body_class', 'typography global-alert');

        $gridField = GridField::create('DefaultHeaderSlides', _t('SilverStripe\SiteConfig\SiteConfig.DEFAULTHEADERSLIDES'), $this->getOwner()->DefaultHeaderSlides(), GridFieldConfig_SortableRelation::create('SortOrder'));
        $gridField->setDescription(_t('SilverStripe\SiteConfig\SiteConfig.DEFAULTHEADERSLIDESDESCRIPTION', 'Displayed on Pages without Hero'));
        $fields->addFieldToTab('Root.Main', $gridField, 'GlobalAlert');

        $sizes = singleton(SiteConfig::class)->dbObject('DefaultHeroSize')->enumValues();
        $SizeField = DropdownField::create('DefaultHeroSize', _t('SilverStripe\SiteConfig\SiteConfig.DEFAULTHEROSIZE', 'Size default slides'), $sizes);
        $fields->addFieldToTab('Root.Main', $SizeField, 'GlobalAlert');

        $fields->addFieldsToTab(
            'Root.Main',
            [
                MultiLinkField::create('ServiceNavigationItems', _t('SilverStripe\SiteConfig\SiteConfig.SERVICENAVIGATIONITEMS', 'Service Navigation'))
                    ->setDescription(_t('SilverStripe\SiteConfig\SiteConfig.ServiceNavigationItemsDescription', 'Links above main navigation in header')),
                MultiLinkField::create('TermsNavigationItems', _t('SilverStripe\SiteConfig\SiteConfig.TERMSNAVIGATIONITEMS', 'Terms Navigation'))
                    ->setDescription(_t('SilverStripe\SiteConfig\SiteConfig.TermsNavigationItemsDescription', 'Links footer (AGB, Legal, Imprint etc.)')),
            ],
        );

        $LocationGridField = GridField::create('Locations', 'Locations', $this->getOwner()->Locations(), GridFieldConfig_OwnRecords::create('Sort'));
        $LocationGridField->setDescription(_t('SilverStripe\SiteConfig\SiteConfig.SortImpact', 'The "Location" in 1st place is displayed in the footer.'));
        $fields->addFieldToTab('Root.Main', $LocationGridField);

        $SnippetGridField = GridField::create('Snipped', 'Snippets', ShortCodeSnippet::get(), GridFieldConfig_OwnRecords::create());
        $fields->addFieldToTab('Root', Tab::create(
            'Snippets',
            'Snippets',
            $SnippetGridField,
        ));

        $SocialGridField = GridField::create('SocialLinks', 'SocialLinks', $this->getOwner()->SocialLinks(), GridFieldConfig_OwnRecords::create('SortOrder'));
        $fields->addFieldToTab('Root.Main', $SocialGridField);

        $vacationString = _t('SilverStripe\SiteConfig\SiteConfig.OpeningHoursVacations', 'Opening hours & Vacations');
        $VacationGridField = GridField::create('Vacations', _t('SilverStripe\SiteConfig\SiteConfig.VacationsHolidays', 'Vacations & Holidays'), $this->getOwner()->Vacations(), GridFieldConfig_OwnRecords::create());
        $VacationGridField->setDescription('<p>[Vacation MonthsInAdvance="6"]</p>' . _t('SilverStripe\SiteConfig\SiteConfig.VACATIONSDESCRIPTION', 'Lists upcoming vacations & holidays. MonthsInAdvance limits how many months ahead are shown (default 6).'));
        $fields->addFieldToTab('Root', Tab::create(
            $vacationString,
            $vacationString,
            ...[...$this->getSchemaTypeNotice(), $this->getOpeningHoursGridField(), $VacationGridField],
        ));
    }

    /**
     * @return LiteralField[]
     */
    protected function getSchemaTypeNotice(): array
    {
        $type = $this->getOwner()->SchemaType ?: 'Organisation';
        if (SchemaBuilder::supportsOpeningHours($this->getOwner())) {
            $class = 'alert-success';
            $message = _t(
                'SilverStripe\SiteConfig\SiteConfig.OpeningHoursSchemaTypeOk',
                'Opening hours and vacations are included in the structured data (schema type "{type}").',
                ['type' => $type],
            );
        } else {
            $class = 'alert-warning';
            $message = _t(
                'SilverStripe\SiteConfig\SiteConfig.OpeningHoursSchemaTypeWarning',
                'The schema type "{type}" does not support opening hours, so they are not included in the structured data. Choose "LocalBusiness" or a subtype in the main tab.',
                ['type' => $type],
            );
        }

        return [LiteralField::create('OpeningHoursSchemaTypeNotice', sprintf('<p class="alert %s">%s</p>', $class, Convert::raw2xml($message)))];
    }

    protected function getOpeningHoursGridField(): GridField
    {
        $days = OpeningHour::dayOptions();
        $label = fn (string $field) => OpeningHour::singleton()->fieldLabel($field);
        $config = GridFieldConfig::create()->addComponents(
            GridFieldButtonRow::create('before'),
            GridFieldTitleHeader::create(),
            GridFieldEditableColumns::create()->setDisplayFields([
                'DayFrom' => ['title' => $label('DayFrom'), 'callback' => fn () => DropdownField::create('DayFrom', '', $days)->setAttribute('style', 'min-width: 9em')],
                'DayTo' => ['title' => $label('DayTo'), 'callback' => fn () => DropdownField::create('DayTo', '', $days)->setEmptyString('–')->setAttribute('style', 'min-width: 9em')],
                'Opens' => ['title' => $label('Opens'), 'callback' => fn () => TimeField::create('Opens', '')->setAttribute('step', 60)],
                'Closes' => ['title' => $label('Closes'), 'callback' => fn () => TimeField::create('Closes', '')->setAttribute('step', 60)],
                'Note' => ['title' => $label('Note'), 'callback' => fn () => TextField::create('Note', '')->setAttribute('style', 'min-width: 14em')],
            ]),
            GridFieldAddNewInlineButton::create('buttons-before-left')->setTitle(_t(SiteConfig::class . '.ADDOPENINGTIME', 'Add opening hours')),
            GridFieldDeleteAction::create(),
            GridFieldOrderableRows::create('Sort'),
        );
        $grid = GridField::create('OpeningHours', _t(SiteConfig::class . '.OPENINGHOURS', 'Opening hours'), $this->getOwner()->OpeningHours(), $config);
        $grid->setDescription(
            '<p>[OpeningHours]</p>' . _t(SiteConfig::class . '.OPENINGHOURSDESCRIPTION', 'One row per time range, e.g. a lunch break means two rows. Leave times empty to mark days as closed. Vacations & Holidays below are interpreted as "closed".'),
        );

        return $grid;
    }

    /**
     * Opening hours as escaped HTML, one line per day span with its time ranges combined,
     * e.g. "Mon – Fri: 08:00 – 12:00 and 13:30 – 17:00"; null if none are maintained.
     *
     * @param string $dayFormat ICU weekday pattern: ccc (Mo), cccc (Montag), ccccc (M), cccccc (Mo)
     */
    public function OpeningHoursHTML(string $dayFormat = 'ccc'): ?string
    {
        $groups = [];
        foreach ($this->getOwner()->OpeningHours() as $range) {
            $key = $range->DayFrom . '|' . $range->DayTo;
            $groups[$key]['days'] ??= $range->getDayLabel($dayFormat);
            $groups[$key]['times'][] = Convert::raw2xml($range->getTimeLabel());
            $groups[$key]['closed'] = ($groups[$key]['closed'] ?? false) || $range->isClosed();
        }

        $suffix = _t(SiteConfig::class . '.OPENINGHOURSSUFFIX', '');
        $listFormatter = new \IntlListFormatter(i18n::get_locale(), \IntlListFormatter::TYPE_AND, \IntlListFormatter::WIDTH_WIDE);
        $lines = [];
        foreach ($groups as $group) {
            $lines[] = Convert::raw2xml($group['days']) . ': ' . $listFormatter->format($group['times']) . ($group['closed'] ? '' : $suffix);
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
        foreach ($this->getOwner()->OpeningHours() as $range) {
            if ($spec = $range->toSchema()) {
                $specs[] = $spec;
            }
        }

        // Closures without regular hours would be meaningless
        if (!$specs) {
            return [];
        }

        // A closure is an all-day range (00:00 - 00:00) limited by validFrom/validThrough
        $vacations = $this->getOwner()->Vacations()->filter('EndDate:GreaterThanOrEqual', date('Y-m-d'))->sort('StartDate ASC');
        foreach ($vacations as $vacation) {
            $specs[] = Schema::openingHoursSpecification()
                ->opens('00:00')
                ->closes('00:00')
                ->validFrom($vacation->StartDate)
                ->validThrough($vacation->EndDate);
        }

        return $specs;
    }
}
