<?php

namespace App\Models;

use App\Model\PersoPage;
use App\Models\Location;
use App\Model\ElementPage;
use Spatie\SchemaOrg\Schema;
use App\Elements\ElementJobs;
use SilverStripe\Assets\File;
use SilverStripe\Assets\Image;
use SilverStripe\ORM\DataObject;
use SilverStripe\Control\Director;
use SilverStripe\Security\Security;
use SilverStripe\Control\Controller;
use SilverStripe\Forms\ListboxField;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Versioned\Versioned;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\View\Parsers\URLSegmentFilter;
use SilverStripe\Core\Manifest\ModuleResourceLoader;

class JobPosting extends DataObject
{
    private static $db = [
        'Sort' => 'Int',
        'Active' => 'Boolean',
        'Title' => 'Varchar',
        'OccupationalCategory' => 'Varchar',
        'Description' => 'HTMLText',
        'Industry' => 'HTMLText',
        'EmploymentType' => "Enum('full-time, part-time, contract, temporary, seasonal, internship','full-time')",
        'WorkHours' => 'Varchar',
        'Skills' => 'Text',
        'Qualifications' => 'Text',
        'EducationRequirements' => 'Text',
        'Responsibilities' => 'Text',
        'ExperienceRequirements' => 'Text',
        'JobBenefits' => 'Text',
        'DatePosted' => 'Date',
        'ValidThrough' => 'Date'
    ];

    private static $has_one = [
        'HeaderImage' => Image::class,
        'Inserat' => File::class,
        'Ansprechperson' => Perso::class,
    ];

    private static $many_many = [
        'JobLocations' => Location::class
    ];

    private static $owns = [
        'HeaderImage',
        'Inserat'
    ];

    private static $table_name = 'JobPosting';

    private static $singular_name = 'Job';
    private static $plural_name = 'Jobs';

    private static $default_sort = 'Sort ASC';

    public function populateDefaults()
    {
        $this->DatePosted = date('Y-m-d');
        $this->ValidThrough = date('Y-m-d', strtotime('now + 1 year'));
        parent::populateDefaults();
    }

    private static $defaults = [
        'Active' => 1
    ];

    private static $field_labels = [
        'Active' => 'Aktiv',
        'Title' => 'Titel',
        'OccupationalCategory' => 'Berufsgruppe',
        'Description' => 'Text sichtbar (Ansicht Website)',
        'Industry' => 'Industrie',
        'EmploymentType' => 'Art der Anstellung',
        'WorkHours' => 'Arbeitszeit pro Woche',
        'Skills' => 'Fähigkeiten',
        'Qualifications' => 'Qualifikationen',
        'EducationRequirements' => 'Anforderung Ausbildung',
        'Responsibilities' => 'Verantwortung',
        'ExperienceRequirements' => 'Anforderungen Erfahrung',
        'JobBenefits' => 'Vorteile (wir bieten...)',
        'DatePosted' => 'Veröffentlichungsdatum',
        'ValidThrough' => 'Gültig bis'
    ];

    private static $summary_fields = [
        'Title' => 'Titel',
        'Active' => 'Aktiv',
        'LastForString' => 'Gültig in Tagen ab Heute',
        'AddressLocalityAsString' => 'Ort'
    ];

    private static $searchable_fields = [
        'Title',
        'Active',
        'JobLocations.Address'
    ];

    public function getCMSFields()
    {

        $fields = parent::getCMSFields();
        $fields->removeByName('Sort');

        $fields->addFieldToTab('Root.Main', LiteralField::create('Link', '<p><a href="' . $this->AbsoluteLink() . '" target="_blank">' . $this->AbsoluteLink() . '</a></p>'), 'Title');

        if ($this->LastFor() == false) {
            $message = _t('App\Models\JobPosting.expiredAlert', 'false');
            $fields->unshift(
                LiteralField::create(
                    'Past',
                    sprintf(
                        '<p class="alert alert-warning">%s</p>',
                        $message
                    )
                )
            );
        }

        if ($TitleField = $fields->dataFieldByName('Title')) {
            $TitleField->setDescription('z.B. Projektleiter 100% (m/w)');
        }

        if ($WorkHoursField = $fields->dataFieldByName('WorkHours')) {
            $WorkHoursField->setDescription('z.B. 42 Stunden pro Woche');
        }

        if ($SkillsField = $fields->dataFieldByName('Skills')) {
            $SkillsField->setDescription('z.B. Englischkenntnisse Kommunikationsfähigkeiten');
        }

        if ($QualificationsField = $fields->dataFieldByName('Qualifications')) {
            $QualificationsField->setDescription('Zertifikate z.B. CCNA LPI NBW<br/>');
        }

        if ($EducationRequirementsField = $fields->dataFieldByName('EducationRequirements')) {
            $EducationRequirementsField->setDescription('z.B. Lehre Hochschule HF/FH ETH UNI');
        }

        if ($JobBenefitsField = $fields->dataFieldByName('JobBenefits')) {
            $JobBenefitsField->setDescription('z.B. 5 Wochen Ferien, flexible Arbeitszeiten<br/>');
        }

        if ($ExperienceRequirementsField = $fields->dataFieldByName('ExperienceRequirements')) {
            $ExperienceRequirementsField->setDescription('z.B. Führungserfahrung<br/>');
        }

        if ($TextEditorField = $fields->dataFieldByName('Description')) {
            $fields->removeByName('Description');
            $fields->addFieldToTab('Root.Text', $TextEditorField);
            $TextEditorField->setRows(50);
            $TextEditorField->addExtraClass('stacked');
            $TextEditorField->setAttribute('data-mce-body-class', 'jobposting');
        }

        if ($JobLocationsField = $fields->dataFieldByName('JobLocations')) {
            $fields->removeByName('JobLocations');
            $Source = function () {
                return Location::get()->map('ID', 'Town')->toArray();
            };
            // $TagField = ListboxField::create('JobLocations', 'Arbeits Ort', $Source())->setMultiple(true);
            $TagField = ListboxField::create('JobLocations', 'Arbeits Ort', $Source());
            $fields->addFieldToTab('Root.Main', $TagField, 'EmploymentType');
        }

        if ($uploadField = $fields->dataFieldByName('HeaderImage')) {
            $uploadField->setFolderName('Jobs');
            $uploadField->setDescription('1:2.1');
        }

        if ($InseratuploadField = $fields->dataFieldByName('Inserat')) {
            $InseratuploadField->allowedExtensions = array('PDF');
            $InseratuploadField->setFolderName('Jobs');
            $InseratuploadField->setDescription('PDF');
        }

        return $fields;
    }

    public function JobPostingSchema()
    {

        $siteConfig = SiteConfig::get()->first();
        $location = $siteConfig->Locations()->first();

        $schema = Schema::jobPosting()
            ->title($this->Title)
            ->description($this->Description)
            ->url($this->AbsoluteLink())
            ->employmentType($this->EmploymentType)
            ->workHours($this->WorkHours)
            ->skills($this->TextAsArray($this->Skills))
            ->qualifications($this->TextAsArray($this->Qualifications))
            ->educationRequirements($this->TextAsArray($this->EducationRequirements))
            ->jobBenefits($this->TextAsArray($this->JobBenefits))
            ->responsibilities($this->TextAsArray($this->Responsibilities))
            ->industry($this->Industry)
            ->occupationalCategory($this->OccupationalCategory)
            ->datePosted($this->DatePosted)
            ->validThrough($this->ValidThrough)

            ->hiringOrganization(Schema::Organization()
                ->name($siteConfig->Title)
                ->sameAs(Director::absoluteBaseURL())
                // https://developers.google.com/search/docs/data-types/logo jpg | png min. 112px square
                ->logo(rtrim(Director::absoluteBaseURL(), '/') . ModuleResourceLoader::resourceURL('icon-512.png')));

        if ($this->JobLocations()->Count()) {
            $locations = [];
            $i = 0;
            foreach ($this->JobLocations() as $location) {

                $country = strtoupper($location->Country);

                $PushLocation = Schema::postalAddress()
                    ->streetAddress($location->Address)
                    ->postalCode($location->PostalCode)
                    ->addressLocality($location->Town)
                    ->addressRegion($location->AddressRegion)
                    ->addressCountry(Schema::Country()
                        ->name($country));

                $locations[$i] = Schema::Place()->address($PushLocation);

                if ($location->GeoPointID) {
                    $PushGeo = Schema::geoCoordinates()
                        ->latitude($location->GeoPoint()->Latitude)
                        ->longitude($location->GeoPoint()->Longitude);

                    $locations[$i]->hasMap($location->GeoPoint()->GMapLatLngLink());
                    $locations[$i]->geo($PushGeo);
                }

                $i++;
            }
            $schema->jobLocation($locations);
        }

        $schema->setProperty('@id', $this->Slug());

        return $schema->toScript();
    }

    public function Parent()
    {
        $e = ElementJobs::get()->filter(['Primary' => 1])->first();
        if (!$e) {
            $e = ElementJobs::get()->first();
        }
        return $e;
    }

    public function Slug()
    {
        $filter = new URLSegmentFilter();
        $anchor = $filter->filter($this->Title);
        if ($this->ID && JobPosting::get()->filter('Title', $this->Title)->count() > 1) {
            $anchor .= '-' . $this->ID;
        }
        return $anchor;
    }

    // URL
    public function AbsoluteLink()
    {
        if ($this->Parent() && $this->Active && $this->isInDB()) {
            $base = Director::absoluteBaseURL();
            $areaID = $this->Parent()->ParentID;
            $Page = ElementPage::get()->filter(['ElementalAreaID' => $areaID])->first();
            $siteURL = $Page->Link();

            return Controller::join_links(
                $base,
                $siteURL,
                '/job/',
                $this->ID
            );
        }
    }

    public function canView($member = null)
    {
        if ($member = Security::getCurrentUser()) {
            return true;
        } else {
            if (!$this->Active) {
                return false;
            }
            if (!$this->LastFor()) {
                return false;
            }
            return true;
        }
    }

    public function TextAsArray($value)
    {
        $entries = explode(PHP_EOL, $value);
        foreach ($entries as $key => $value) {
            $v = trim($value);
            if ($v != '') {
                $entries[$key] = $v;
            } else {
                unset($entries[$key]);
            }
        }
        return $entries;
    }

    public function ExplicitLiveParentLink()
    {
        $id = $this->Parent()->Page->ID;
        $link = Versioned::get_by_stage('ElementPage', 'Live')->filter('ID', $id)->first()->link();
        return $link;
    }

    public function getAddressLocalityAsString()
    {
        return implode(', ', $this->JobLocations()->Column('Town'));
    }

    public function LastFor()
    {
        $now = time();
        $valid = strtotime($this->ValidThrough);
        $datediff = $now - $valid;
        $datediff = round($datediff / (60 * 60 * 24));
        if ($datediff > 1) {
            $datediff = false;
        }
        return abs($datediff);
    }

    public function LastForString()
    {
        $datediff = $this->LastFor();
        if ($datediff == false && $this->ValidThrough) {
            $html = DBHTMLText::create();
            $html->setValue('<span style="color: red;">' . _t('App\Models\JobPosting.expired', 'false') . '</span>');
            $datediff = $html;
        }
        return $datediff;
    }

    // sitemap.xml
    public function getGooglePriority()
    {
        return 1;
    }
}
