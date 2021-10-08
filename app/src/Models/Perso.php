<?php

namespace App\Models;

use App\Models\Department;
use Spatie\SchemaOrg\Schema;
use App\Elements\ElementPerso;
use SilverStripe\Assets\Image;
use SilverStripe\ORM\ArrayList;
use SilverStripe\View\SSViewer;
use SilverStripe\ORM\DataObject;
use SilverStripe\View\ArrayData;
use SilverStripe\Forms\EmailField;
use SilverStripe\Control\Controller;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\View\Parsers\URLSegmentFilter;
use SilverStripe\Forms\GridField\GridFieldDetailForm;
use SilverStripe\Forms\GridField\GridFieldEditButton;
use SilverStripe\Forms\GridField\GridFieldConfig_Base;
use SilverStripe\Forms\GridField\GridFieldAddNewButton;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;

class Perso extends DataObject
{
    private static $db = [
        'Firstname' => 'Varchar',
        'Lastname' => 'Varchar',
        'Position' => 'Text',
        'EMail' => 'Varchar',
        'Telephone' => 'Varchar',
        'Motivation' => 'HTMLText'
    ];

    private static $has_one = [
        'Portrait' => Image::class
    ];

    private static $many_many = [
        'SocialLinks' => SocialLink::class
    ];

    private static $many_many_extraFields = [
        'SocialLinks' => [
            'SortOrder' => 'Int'
        ]
    ];

    private static $belongs_many_many = [
        'Departments' => Department::class
    ];

    private static $owns = [
        'Portrait'
    ];

    private static $table_name = 'Perso';

    private static $summary_fields = [
        'Portrait.CMSThumbnail' => 'Thumbnail',
        'Firstname' => 'Vorname',
        'Lastname' => 'Nachname'
    ];

    private static $searchable_fields = [
        'Firstname',
        'Lastname'
    ];

    private static $translate = [
        'Position',
        'Motivation'
    ];

    public function fieldLabels($includerelations = true)
    {
        $labels = parent::fieldLabels($includerelations);
        $labels['Firstname'] = _t(__CLASS__ . '.FIRSTNAME', 'First name');
        $labels['Lastname'] = _t(__CLASS__ . '.LASTNAME', 'Last name');
        $labels['EMail'] = _t(__CLASS__ . '.EMAIL', 'E-Mail');
        $labels['Telephone'] = _t(__CLASS__ . '.TELEPHONE', 'Phone');
        $labels['Motivation'] = _t(__CLASS__ . '.MOTIVATION', 'Text');

        return $labels;
    }

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->replaceField('EMail', EmailField::create('EMail', 'E-Mail'));

        if ($TelephoneField = $fields->dataFieldByName('Telephone')) {
            $TelephoneField->setDescription(_t(__CLASS__ . '.TelephoneDescription', '+41 43 000 00 00'));
        }

        if ($MotivationField = $fields->dataFieldByName('Motivation')) {
            $MotivationField->addExtraClass('stacked');
            $MotivationField->setAttribute('data-mce-body-class', 'persoeditor');
            $MotivationField->setRows(10);
        }

        if ($MAuploadField = $fields->dataFieldByName('Portrait')) {
            $MAuploadField->setFolderName('Portraits');
            $size = 5 * 1024 * 1024;
            $MAuploadField->getValidator()->setAllowedMaxFileSize($size);
            $MAuploadField->setDescription(_t(__CLASS__ . '.PortraitDescription', 'min. 576x766px'));
        }
        // $fields->insertAfter($MAuploadField, 'Title');
        $fields->insertBefore($MAuploadField, 'Motivation');

        if ($this->isInDB()) {
            $fields
                ->fieldByName('Root.Departments.Departments')
                ->getConfig()
                ->removeComponentsByType([
                    GridFieldEditButton::class,
                    GridFieldAddNewButton::class
                ]);
        }

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

        return $fields;
    }

    public function getTitle()
    {
        return $this->Firstname . ' ' . $this->Lastname;
    }

    public function Anchor()
    {
        $filter = new URLSegmentFilter();
        $Sibelings = Perso::get()->exclude("ID", $this->ID);
        $Anchor = $filter->filter($this->Firstname . ' ' . $this->Lastname);
        if ($Sibelings->filter(['Firstname' => $this->Firstname, 'Lastname' => $this->Lastname])->count()) {
            $Anchor = $Anchor . '-' . $this->ID;
        }
        return $Anchor;
    }

    public function canView($member = null)
    {
        return true;
    }

    public function Breadcrumbs($maxDepth = 20, $unlinked = false, $stopAtPageType = false, $showHidden = false)
    {
        $page = Controller::curr();
        $pages = array();
        $pages[] = $this->owner;
        while ($page
            && (!$maxDepth || count($pages) < $maxDepth)
            && (!$stopAtPageType || $page->ClassName != $stopAtPageType)
        ) {
            if ($showHidden || $page->ShowInMenus || ($page->ID == $this->owner->ID)) {
                $pages[] = $page;
            }
            $page = $page->Parent;
        }
        $template = new SSViewer('BreadcrumbsTemplate');

        return $template->process($this->owner->customise(new ArrayData(array(
            'Pages' => new ArrayList(array_reverse($pages)),
        ))));
    }

    public function PersoSchema() {
        $schemaPerson = Schema::person();
        $schemaPerson
            ->name($this->getTitle())
            ->image($this->MitafotoGesicht->Link())
            ->jobTitle($this->Position)
            ->email($this->EMail)
            ->telephone($this->Telephone)
            ->url($this->AbsoluteLink());

        if ($this->SocialLinks()->filter('sameAs', 1)->Count()) {
            $sameAsLinks = $$this->SocialLinks()->filter('sameAs', 1)->Column('Url');
            $schemaPerson->sameAs($sameAsLinks);
        }

        return $schemaPerson->toScript();
    }
}
