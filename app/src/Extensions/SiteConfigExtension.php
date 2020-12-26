<?php

namespace App\Extensions;

use App\Models\Location;
use App\Models\SocialLink;
use gorriecoe\Link\Models\Link;
use SilverStripe\Assets\Image;
use SilverStripe\Core\Extension;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\HeaderField;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Forms\GridField\GridFieldDetailForm;
use SilverStripe\Forms\GridField\GridFieldEditButton;
use SilverStripe\Forms\GridField\GridFieldConfig_Base;
use SilverStripe\Forms\GridField\GridFieldAddNewButton;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use SilverStripe\Forms\GridField\GridFieldFilterHeader;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use SilverStripe\Forms\GridField\GridFieldAddExistingAutocompleter;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\Forms\TextareaField;

class SiteConfigExtension extends Extension
{
    private static $db = [
        'MetaDescription' => 'Varchar',
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
        'Tagline',
        'MetaDescription'
    ];

    public function updateCMSFields(FieldList $fields)
    {
        $fields->removeByName('Tagline');

        $fields->renameField('Title', _t('SilverStripe\SiteConfig\SiteConfig.TITLE', 'Title / Name'));

        $fields->addFieldToTab('Root.Main', HeaderField::create('MetaData', 'Meta Daten'));
        $fields->addFieldToTab('Root.Main', $MetaDescriptionField = TextAreaField::create('MetaDescription', _t('SilverStripe\SiteConfig\SiteConfig.METADESCRIPTION', 'Meta Description')));
        $MetaDescriptionField->setTargetLength(160, 100, 160);
        $MetaDescriptionField->setDescription(_t('SilverStripe\SiteConfig\SiteConfig.MetaDescriptionDescription', 'Defaultwert, falls auf Seitenebene keine Beschreibung erfasst ist.'));

        $fields->addFieldsToTab('Root.Main', $GlobalAlertField = HTMLEditorField::create('GlobalAlert'));
        $GlobalAlertField->setRows(14);
        $GlobalAlertField->addExtraClass('stacked');
        $GlobalAlertField->setAttribute('data-mce-body-class', 'global-alert');

        $fields->addFieldToTab(
            'Root.Main',
            $SlideBildField = UploadField::create(
                $name = 'DefaultHeaderImage',
                $title = _t('SilverStripe\SiteConfig\SiteConfig.DEFAULTHEADERIMAGE', 'Wird angezeigt, falls kein Hero in ElementPage')
            )
        );
        $SlideBildField->setFolderName('Slides');
        $SlideBildField->setDescription(_t('SilverStripe\SiteConfig\SiteConfig.DefaultHeaderImageDescription', '2600x993px'));

        $ServiceNavigationGridFieldConfig = GridFieldConfig_Base::create(20);
        $ServiceNavigationGridFieldConfig->addComponents(
            new GridFieldEditButton(),
            new GridFieldDeleteAction(false),
            new GridFieldDeleteAction(true),
            new GridFieldDetailForm(),
            new GridFieldAddNewButton('toolbar-header-right'),
            new GridFieldAddExistingAutocompleter('toolbar-header-right'),
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

        $gridField = new GridField('TermsNavigationItems', _t('SilverStripe\SiteConfig\SiteConfig.TERMSNAVIGATIONITEMS', 'Terms (AGB, Rechtliches, Impressum)'), $this->owner->TermsNavigationItems(), $TermsNavigationGridFieldConfig);

        $fields->addFieldToTab('Root.Main', $gridField);


        $SocialConf = GridFieldConfig_Base::create(20);
        $SocialConf->removeComponentsByType([
            GridFieldFilterHeader::class
        ]);


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
            LiteralField::create('SortImpact', '<p>'. _t('SilverStripe\SiteConfig\SiteConfig.SortImpact', 'Die "Location" an 1. Stelle wird im Footer angezeigt. Für "Schema-Daten" wie LocalBusiness werden alle verwendet.') .'</p>')
        );


        $SocialConf = GridFieldConfig_Base::create(20);
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
