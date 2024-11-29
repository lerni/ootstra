<?php

namespace App\Extensions;

use App\Models\Slide;
use App\Models\Location;
use App\Models\Vacation;
use App\Models\SocialLink;
use SilverStripe\Forms\Tab;
use App\Model\ShortCodeSnippet;
use SilverStripe\Core\Extension;
use SilverStripe\Forms\DateField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\HeaderField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\TextareaField;
use SilverStripe\ORM\FieldType\DBDate;
use SilverStripe\LinkField\Models\Link;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\LinkField\Form\MultiLinkField;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\Forms\GridField\GridFieldDetailForm;
use SilverStripe\Forms\GridField\GridFieldEditButton;
use SilverStripe\Forms\GridField\GridFieldConfig_Base;
use SilverStripe\Forms\GridField\GridFieldAddNewButton;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use SilverStripe\Forms\GridField\GridFieldFilterHeader;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use SilverStripe\Forms\GridField\GridFieldAddExistingAutocompleter;

class SiteConfigExtension extends Extension
{
    private static $db = [
        'MetaDescription' => 'Varchar',
        'legalName' => 'Varchar',
        'foundingDate' => DBDate::class,
        'GlobalAlert' => 'HTMLText',
        'DefaultHeroSize' => 'Enum("small,medium","small")',
        'SchemaType' => 'Varchar'
    ];

    private static $has_one = [];

    private static $has_many = [
        'Locations' => Location::class,
        'ServiceNavigationItems' => Link::class . '.Owner',
        'TermsNavigationItems' => Link::class . '.Owner',
        'Vacation' => Vacation::class
    ];

    private static $many_many = [
        'SocialLinks' => SocialLink::class,
        'DefaultHeaderSlides' => Slide::class
    ];

    private static $many_many_extraFields = [
        'SocialLinks' => [
            'SortOrder' => 'Int'
        ],
        'DefaultHeaderSlides' => [
            'SortOrder' => 'Int'
        ]
    ];

    private static $owns = [
        'DefaultHeaderSlides',
        'ServiceNavigationItems',
        'TermsNavigationItems'
    ];

    private static $translate = [
        'Title',
        'MetaDescription'
    ];

    public function updateCMSFields(FieldList $fields)
    {
        $fields->removeByName([
            'Tagline'
        ]);

        $fields->renameField('Title', _t('SilverStripe\SiteConfig\SiteConfig.TITLE', 'Title / Name'));

        $fields->addFieldToTab('Root.Main', $legalNameField = TextField::create('legalName', _t('SilverStripe\SiteConfig\SiteConfig.LEGALNAME', 'Official name (legal)')));
        $fields->addFieldToTab('Root.Main', $foundingDateField = DateField::create('foundingDate', _t('SilverStripe\SiteConfig\SiteConfig.FOUNDINGDATE', 'Date of foundation'))->setHTML5(true));

        $schemaTypeKeys = array_keys(PageSchemaExtension::AvailableSchemaTypes());
        $schemaTypes = array_combine($schemaTypeKeys, $schemaTypeKeys);
        $fields->addFieldToTab('Root.Main', $schmeTypeField = DropdownField::create('SchemaType', _t('SilverStripe\SiteConfig\SiteConfig.SCHEMATYPE', 'Schema Type'), $schemaTypes));

        $fields->addFieldToTab('Root.Main', HeaderField::create('MetaData', 'Meta Daten'));
        $fields->addFieldToTab('Root.Main', $MetaDescriptionField = TextAreaField::create('MetaDescription', _t('SilverStripe\SiteConfig\SiteConfig.METADESCRIPTION', 'Meta Description')));
        $MetaDescriptionField->setTargetLength(160, 100, 160);
        $MetaDescriptionField->setDescription(_t('SilverStripe\SiteConfig\SiteConfig.MetaDescriptionDescription', 'Default value if no description is present at page level.'));

        $fields->addFieldsToTab('Root.Main', $GlobalAlertField = HTMLEditorField::create('GlobalAlert'));
        $GlobalAlertField->setRows(14);
        $GlobalAlertField->setEditorConfig('inlite'); // we need to use a different config, otherwise the "body_class" is overwritten also for editors with bigfork/silverstripe-fail-whale
        $GlobalAlertField->getEditorConfig()->setOption('body_class', 'typography global-alert');

        $SlideGridFieldConfig = GridFieldConfig_Base::create(20);
        $SlideGridFieldConfig->addComponents(
            new GridFieldEditButton(),
            new GridFieldDeleteAction(false),
            new GridFieldDeleteAction(true),
            new GridFieldDetailForm(),
            new GridFieldAddNewButton('toolbar-header-left'),
            new GridFieldAddExistingAutocompleter('toolbar-header-right'),
            new GridFieldOrderableRows('SortOrder')
        );
        $SlideGridFieldConfig->removeComponentsByType(GridFieldFilterHeader::class);
        $gridField = new GridField('DefaultHeaderSlides', _t('SilverStripe\SiteConfig\SiteConfig.DEFAULTHEADERSLIDES'), $this->owner->DefaultHeaderSlides(), $SlideGridFieldConfig);
        $gridField->setDescription(_t('SilverStripe\SiteConfig\SiteConfig.DEFAULTHEADERSLIDESDESCRIPTION', 'Displayed on Pages without Hero'));
        $fields->addFieldToTab('Root.Main', $gridField, 'GlobalAlert');

        $sizes = singleton(SiteConfig::class)->dbObject('DefaultHeroSize')->enumValues();
        $SizeField = DropdownField::create('DefaultHeroSize', _t('SilverStripe\SiteConfig\SiteConfig.DEFAULTHEROSIZE', 'Size default slides'), $sizes);
        $fields->addFieldToTab('Root.Main', $SizeField, 'GlobalAlert', true);

        $fields->addFieldsToTab(
            'Root.Main',
            [
                MultiLinkField::create('ServiceNavigationItems', _t('SilverStripe\SiteConfig\SiteConfig.SERVICENAVIGATIONITEMS', 'Service Navigation'))
                    ->setDescription(_t('SilverStripe\SiteConfig\SiteConfig.ServiceNavigationItemsDescription', 'Links above main navigation in header')),
                MultiLinkField::create('TermsNavigationItems', _t('SilverStripe\SiteConfig\SiteConfig.TERMSNAVIGATIONITEMS', 'Terms Navigation'))
                    ->setDescription(_t('SilverStripe\SiteConfig\SiteConfig.TermsNavigationItemsDescription', 'Links footer (AGB, Legal, Imprint etc.)'))
            ]
        );

        $LocationConf = GridFieldConfig_Base::create(20);
        $LocationConf->removeComponentsByType([
            GridFieldFilterHeader::class
        ]);
        $LocationConf->addComponents(
            new GridFieldEditButton(),
            new GridFieldDeleteAction(false),
            new GridFieldDetailForm(),
            new GridFieldOrderableRows('Sort'),
            new GridFieldAddNewButton('toolbar-header-left')
        );

        $LocationGridField = new GridField('Locations', 'Locations', $this->owner->Locations(), $LocationConf);
        $LocationGridField->setDescription(_t('SilverStripe\SiteConfig\SiteConfig.SortImpact', 'The "Location" in 1st place is displayed in the footer.'));
        $fields->addFieldToTab('Root.Main', $LocationGridField);


        $SnippetGFConf = GridFieldConfig_Base::create(20);
        $SnippetGFConf->removeComponentsByType([
            GridFieldFilterHeader::class
        ]);
        $SnippetGFConf->addComponents(
            new GridFieldEditButton(),
            new GridFieldDeleteAction(false),
            new GridFieldDetailForm(),
            new GridFieldAddNewButton('toolbar-header-left')
        );
        $SnippetGridField = new GridField('Snipped', 'Snippets', ShortCodeSnippet::get(), $SnippetGFConf);
        $fields->addFieldToTab('Root', Tab::create('Snippets', 'Snippets',
            $SnippetGridField
        ));


        $SocialConf = GridFieldConfig_Base::create(20);
        $SocialConf->removeComponentsByType([
            GridFieldFilterHeader::class
        ]);
        $SocialConf->addComponents(
            new GridFieldEditButton(),
            new GridFieldDeleteAction(false),
            new GridFieldDetailForm(),
            new GridFieldOrderableRows('SortOrder'),
            new GridFieldAddNewButton('toolbar-header-left')
        );

        $SocialGridField = new GridField('SocialLinks', 'SocialLinks', $this->owner->SocialLinks(), $SocialConf);
        $fields->addFieldToTab('Root.Main', $SocialGridField);

        $VacationGFConf = GridFieldConfig_Base::create(20);
        $VacationGFConf->removeComponentsByType([
            GridFieldFilterHeader::class
        ]);
        $VacationGFConf->addComponents(
            new GridFieldEditButton(),
            new GridFieldDeleteAction(false),
            new GridFieldDetailForm(),
            new GridFieldAddNewButton('toolbar-header-left')
        );
        $vacationString = _t('SilverStripe\SiteConfig\SiteConfig.VacationsHolidays', 'Vacations & Holidays');
        $VacttionGridField = new GridField('Vacation', "$vacationString" , Vacation::get(), $VacationGFConf);
        $fields->addFieldToTab('Root', Tab::create("$vacationString", "$vacationString",
            $VacttionGridField
        ));
    }
}
