<?php

namespace App\Extensions;

use App\Models\Slide;
use App\Models\Location;
use App\Models\SocialLink;
use gorriecoe\Link\Models\Link;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\HeaderField;
use SilverStripe\ORM\DataExtension;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\TextareaField;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\Forms\GridField\GridFieldDetailForm;
use SilverStripe\Forms\GridField\GridFieldEditButton;
use SilverStripe\Forms\GridField\GridFieldConfig_Base;
use SilverStripe\Forms\GridField\GridFieldAddNewButton;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use SilverStripe\Forms\GridField\GridFieldFilterHeader;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use SilverStripe\Forms\GridField\GridFieldAddExistingAutocompleter;

class SiteConfigExtension extends DataExtension
{
    private static $db = [
        'MetaDescription' => 'Varchar',
        'legalName' => 'Varchar',
        'foundingDate' => 'Varchar',
        'GlobalAlert' => 'HTMLText',
        'DefaultHeroSize' => 'Enum("small,medium","small")'
    ];

    private static $has_one = [];

    private static $has_many = [
        'Locations' => Location::class
    ];

    private static $many_many = [
        'ServiceNavigationItems' => Link::class,
        'TermsNavigationItems' => SiteTree::class,
        'SocialLinks' => SocialLink::class,
        'DefaultHeaderSlides' => Slide::class
    ];

    private static $many_many_extraFields = [
        'ServiceNavigationItems' => [
            'SortOrder' => 'Int'
        ],
        'TermsNavigationItems' => [
            'SortOrder' => 'Int'
        ],
        'SocialLinks' => [
            'SortOrder' => 'Int'
        ],
        'DefaultHeaderSlides' => [
            'SortOrder' => 'Int'
        ]
    ];

    private static $owns = [
        'DefaultHeaderSlides'
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
        $fields->addFieldToTab('Root.Main', $foundingDateField = TextField::create('foundingDate', _t('SilverStripe\SiteConfig\SiteConfig.FOUNDINGDATE', 'Date of foundation')));

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
            new GridFieldAddNewButton('toolbar-header-right'),
            new GridFieldAddExistingAutocompleter('toolbar-header-right')
        );
        $SlideGridFieldConfig->addComponent(new GridFieldOrderableRows('SortOrder'));
        $gridField = new GridField('DefaultHeaderSlides', _t('SilverStripe\SiteConfig\SiteConfig.DEFAULTHEADERSLIDES'), $this->owner->DefaultHeaderSlides(), $SlideGridFieldConfig);
        $gridField->setDescription(_t('SilverStripe\SiteConfig\SiteConfig.DEFAULTHEADERSLIDESDESCRIPTION', 'Displayed on Pages without Hero'));
        $fields->addFieldToTab('Root.Main', $gridField, 'GlobalAlert');

        $sizes = singleton(SiteConfig::class)->dbObject('DefaultHeroSize')->enumValues();
        $SizeField = DropdownField::create('DefaultHeroSize', _t('SilverStripe\SiteConfig\SiteConfig.DEFAULTHEROSIZE', 'Size default slides'), $sizes);
        $fields->addFieldToTab('Root.Main', $SizeField, 'GlobalAlert', true);


        $ServiceNavigationGridFieldConfig = GridFieldConfig_Base::create(20);
        $ServiceNavigationGridFieldConfig->addComponents(
            new GridFieldEditButton(),
            new GridFieldDeleteAction(false),
            new GridFieldDetailForm(),
            new GridFieldAddNewButton('toolbar-header-right'),
            new GridFieldOrderableRows('SortOrder')
        );

        $gridField = new GridField('ServiceNavigationItems', _t('SilverStripe\SiteConfig\SiteConfig.SERVICENAVIGATIONITEMS', 'Service Navigation'), $this->owner->ServiceNavigationItems(), $ServiceNavigationGridFieldConfig);

        $fields->addFieldToTab('Root.Main', $gridField);


        $TermsNavigationGridFieldConfig = GridFieldConfig_Base::create(20);
        $TermsNavigationGridFieldConfig->removeComponentsByType([
            GridFieldFilterHeader::class
        ]);
        $TermsNavigationGridFieldConfig->addComponents(
            new GridFieldAddExistingAutocompleter('toolbar-header-right'),
            new GridFieldDeleteAction(true), // this is unlink
            new GridFieldOrderableRows('SortOrder')
        );

        $gridField = new GridField('TermsNavigationItems', _t('SilverStripe\SiteConfig\SiteConfig.TERMSNAVIGATIONITEMS', 'Terms (AGB, Legal, Imprint)'), $this->owner->TermsNavigationItems(), $TermsNavigationGridFieldConfig);

        $fields->addFieldToTab('Root.Main', $gridField);


        $LocationConf = GridFieldConfig_Base::create(20);
        $LocationConf->addComponents(
            new GridFieldEditButton(),
            new GridFieldDeleteAction(false),
            new GridFieldDetailForm(),
            new GridFieldOrderableRows('Sort'),
            new GridFieldAddNewButton('toolbar-header-right')
        );

        $LocationGridField = new GridField('Locations', 'Locations', $this->owner->Locations(), $LocationConf);
        $fields->addFieldToTab('Root.Main', $LocationGridField);
        $fields->addFieldToTab(
            'Root.Main',
            LiteralField::create('SortImpact', '<p>' . _t('SilverStripe\SiteConfig\SiteConfig.SortImpact', 'The "Location" in 1st place is displayed in the footer. For "schema data", all are used.') .'</p>')
        );


        $SocialConf = GridFieldConfig_Base::create(20);
        $SocialConf->removeComponentsByType([
            GridFieldFilterHeader::class
        ]);
        $SocialConf->addComponents(
            new GridFieldEditButton(),
            new GridFieldDeleteAction(false),
            new GridFieldDetailForm(),
            new GridFieldOrderableRows('SortOrder'),
            new GridFieldAddNewButton('toolbar-header-right')
        );

        $SocialGridField = new GridField('SocialLinks', 'SocialLinks', $this->owner->SocialLinks(), $SocialConf);
        $fields->addFieldToTab('Root.Main', $SocialGridField);
    }
}
