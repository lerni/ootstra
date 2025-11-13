<?php

namespace App\Models;

use App\Models\Department;
use Spatie\SchemaOrg\Schema;
use SilverStripe\Assets\Image;
use SilverStripe\ORM\DataObject;
use App\Elements\ElementPersoCFA;
use SilverStripe\Forms\EmailField;
use SilverStripe\TagField\TagField;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\View\Parsers\URLSegmentFilter;
use SilverStripe\Forms\GridField\GridFieldDetailForm;
use SilverStripe\Forms\GridField\GridFieldEditButton;
use SilverStripe\Forms\GridField\GridFieldConfig_Base;
use SilverStripe\Forms\GridField\GridFieldDataColumns;
use SilverStripe\Forms\GridField\GridFieldAddNewButton;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use SilverStripe\Forms\GridField\GridFieldFilterHeader;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use SilverStripe\Forms\Validation\RequiredFieldsValidator;

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
        'Lastname' => 'Nachname',
        'DepartmentsString' => 'Abteilungen'
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
            $MotivationField->getEditorConfig()->setOption('body_class', 'typography perso background--' . $this->owner->BackgroundColor);
            $MotivationField->setRows(10);
        }

        if ($MAuploadField = $fields->dataFieldByName('Portrait')) {
            $MAuploadField->setFolderName('Portraits');
            $MAuploadField->setDescription(_t(__CLASS__ . '.PortraitDescription', 'min. 576x766px'));
        }
        // $fields->insertAfter($MAuploadField, 'Title');
        $fields->insertBefore('Motivation', $MAuploadField);

        // hack around unsaved relations
        if ($this->isInDB()) {

                $fields->removeByName('Departments');
                $DepartmentsField = TagField::create(
                    'Departments',
                    _t('SilverStripe\Blog\Model\Blog.Departments', 'Departments'),
                    Department::get(),
                    $this->Departments()
                );
                $fields->addFieldToTab('Root.Main', $DepartmentsField);

                $SocialConf = GridFieldConfig_Base::create(20);
                $SocialConf->removeComponentsByType([
                    GridFieldFilterHeader::class
                ]);
                $SocialConf->addComponents(
                    new GridFieldEditButton(),
                    new GridFieldDeleteAction(false),
                    new GridFieldDetailForm(),
                    new GridFieldAddNewButton('toolbar-header-left'),
                    new GridFieldOrderableRows('SortOrder')
                );

            // show where associated per CFAElement
            $persoOnCFAElementConfig = GridFieldConfig_Base::create(20);
            $persoOnCFAElementConfig->removeComponentsByType(GridFieldFilterHeader::class);
            $persoOnCFAElementConfig->getComponentByType(GridFieldDataColumns::class)
                ->setDisplayFields([
                    'getTypeBreadcrumb' => 'Element',
                    'getPage.CMSEditLink' => 'Edit-Link'
                ]);
            $persoCFAElements = ElementPersoCFA::get()->filter(["Persos.ID" => $this->ID]);
            $persoOnCFAElementWithMEGridField = new GridField('PersoOnCFAElement', 'PersoOnCFAElement', $persoCFAElements, $persoOnCFAElementConfig);
            $persoOnCFAElementWithMEGridField->setTitle(_t(__CLASS__ . '.IsUsedOnComment', '"{name}" is associated on', ['name' => $this->getTitle()]));
            $fields->addFieldToTab('Root.Main', $persoOnCFAElementWithMEGridField);
        } else {
            $fields->addFieldToTab('Root.Main', LiteralField::create('firstsave', '<p style="font-weight:bold; color:#555;">' . _t('SilverStripe\CMS\Controllers\CMSMain.SaveFirst', 'none') . '</p>'));
        }

        return $fields;
    }

    public function getTitle()
    {
        return implode(' ', [$this->Firstname, $this->Lastname]);
    }

    public function DepartmentsString() {
        return implode(', ', $this->Departments()->Column('Title'));
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

    public function PersoSchema() {
        $schemaPerson = Schema::person();
        $schemaPerson
            ->name($this->getTitle())
            ->image($this->Portrait->AbsoluteLink())
            ->jobTitle($this->Position)
            ->email($this->EMail)
            ->telephone($this->Telephone)
            ->url($this->AbsoluteLink());

        if ($this->SocialLinks()->filter('sameAs', 1)->Count()) {
            $sameAsLinks = $this->SocialLinks()->filter('sameAs', 1)->Column('Url');
            $schemaPerson->sameAs($sameAsLinks);
        }

        return $schemaPerson->toScript();
    }

    public function QRURL()
    {
        if ($this->Departments()->count && $this->Departments()->first()->PersoElement()) {
            return $this->Departments()->first()->PersoElement()->first()->getController()->qrvc($this->ID);
        }
    }

    public function getCMSValidator()
    {
        return RequiredFieldsValidator::create([
            'Firstname',
            'Lastname'
        ]);
    }
}
