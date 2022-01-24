<?php

namespace App\Extensions;

use App\Models\Location;
use App\Models\SocialLink;
use SilverStripe\Assets\Image;
use gorriecoe\Link\Models\Link;
use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\HeaderField;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\AssetAdmin\Forms\UploadField;
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
        'GlobalAlert' => 'HTMLText'
    ];

    private static $has_one = [
        'DefaultHeaderImage' => Image::class
    ];

    private static $has_many = [
        'Locations' => Location::class
    ];

    private static $many_many = [
        'ServiceNavigationItems' => Link::class,
        'TermsNavigationItems' => SiteTree::class,
        'SocialLinks' => SocialLink::class
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
        ]
    ];

    private static $owns = [
        'DefaultHeaderImage'
    ];

    private static $translate = [
        'Title',
        'MetaDescription'
    ];

    public function updateCMSFields(FieldList $fields)
    {
        $fields->removeByName('Tagline');

        $fields->renameField('Title', _t('SilverStripe\SiteConfig\SiteConfig.TITLE', 'Title / Name'));

        $fields->addFieldToTab('Root.Main', $legalNameField = TextField::create('legalName', _t('SilverStripe\SiteConfig\SiteConfig.LEGALNAME', 'Official name (legal)')));
        $fields->addFieldToTab('Root.Main', $foundingDateField = TextField::create('foundingDate', _t('SilverStripe\SiteConfig\SiteConfig.FOUNDINGDATE', 'Date of foundation')));

        $fields->addFieldToTab('Root.Main', HeaderField::create('MetaData', 'Meta Daten'));
        $fields->addFieldToTab('Root.Main', $MetaDescriptionField = TextAreaField::create('MetaDescription', _t('SilverStripe\SiteConfig\SiteConfig.METADESCRIPTION', 'Meta Description')));
        $MetaDescriptionField->setTargetLength(160, 100, 160);
        $MetaDescriptionField->setDescription(_t('SilverStripe\SiteConfig\SiteConfig.MetaDescriptionDescription', 'Default value if no description is present at page level.'));

        $fields->addFieldsToTab('Root.Main', $GlobalAlertField = HTMLEditorField::create('GlobalAlert'));
        $GlobalAlertField->setRows(14);
        $GlobalAlertField->setAttribute('data-mce-body-class', 'global-alert');

        $fields->addFieldToTab(
            'Root.Main',
            $DefaultHeaderImageField = UploadField::create(
                $name = 'DefaultHeaderImage',
                $title = _t('SilverStripe\SiteConfig\SiteConfig.DEFAULTHEADERIMAGE', 'Displayed if no Hero in ElementPage')
            )
        );
        $DefaultHeaderImageField->setFolderName('Slides');
        $size = 5 * 1024 * 1024;
        $DefaultHeaderImageField->getValidator()->setAllowedMaxFileSize($size);
        $DefaultHeaderImageField->setDescription(_t('SilverStripe\SiteConfig\SiteConfig.DefaultHeaderImageDescription', '2600x993px'));

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
            LiteralField::create('SortImpact', '<p>'. _t('SilverStripe\SiteConfig\SiteConfig.SortImpact', 'The "Location" in 1st place is displayed in the footer. For "schema data", all are used.') .'</p>')
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
