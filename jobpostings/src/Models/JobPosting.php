<?php

namespace Kraftausdruck\Models;

use App\Models\Location;
use App\Models\ElementPage;
use Spatie\SchemaOrg\Schema;
use SilverStripe\Assets\File;
use SilverStripe\Assets\Image;
use SilverStripe\ORM\DataObject;
use SilverStripe\Control\Director;
use SilverStripe\Security\Security;
use SilverStripe\View\Requirements;
use SilverStripe\Control\Controller;
use SilverStripe\Forms\ListboxField;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Versioned\Versioned;
use Kraftausdruck\Elements\ElementJobs;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\View\Parsers\URLSegmentFilter;
use SilverStripe\CMS\Forms\SiteTreeURLSegmentField;
use SilverStripe\Core\Manifest\ModuleResourceLoader;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;

class JobPosting extends DataObject
{
    private static $db = [
        'Sort' => 'Int',
        'Active' => 'Boolean',
        'Title' => 'Varchar',
        'URLSegment' => 'Varchar',
//      'OccupationalCategory' => 'Varchar',
        'Description' => 'HTMLText',
        'Industry' => 'Varchar',
        'EmploymentType' => "Enum('full-time, part-time, contract, temporary, seasonal, internship','full-time')",
//      'WorkHours' => 'Varchar',
//      'Skills' => 'Text',
//      'Qualifications' => 'Text',
//      'EducationRequirements' => 'Text',
//      'Responsibilities' => 'Text',
//      'ExperienceRequirements' => 'Text',
//      'JobBenefits' => 'Text',
        'DatePosted' => 'Date',
        'ValidThrough' => 'Date'
    ];

    private static $has_one = [
        'HeaderImage' => Image::class,
        'Inserat' => File::class
    ];

    private static $many_many = [
        'JobLocations' => Location::class
    ];

    private static $owns = [
        'HeaderImage',
        'Inserat'
    ];

    private static $indexes = [
        'URLSegment' => true
    ];

    private static $table_name = 'JobPosting';

    private static $singular_name = 'Job';
    private static $plural_name = 'Jobs';

    private static $default_sort = 'Sort ASC';

    public function populateDefaults()
    {
        $this->DatePosted = date('Y-m-d');
        $this->ValidThrough = date('Y-m-d', strtotime('now + 1 year'));
        if (JobDefaults::get()->count())
        {
            $defaults = JobDefaults::get()->first();
//            $this->Idustrie = $defaults->Idustrie;
//             $this->WorkHours = $defaults->WorkHours;
            $this->HeaderImage = $defaults->HeaderImage;
        }
        parent::populateDefaults();
    }

    private static $defaults = [
        'Active' => 1
    ];

    private static $field_labels = [
        'Active' => 'Aktiv/Veröffentlicht',
        'Title' => 'Titel',
        // 'OccupationalCategory' => 'Berufsgruppe',
        'Description' => 'Text sichtbar (Ansicht Website)',
        'Industry' => 'Industrie',
        'EmploymentType' => 'Art der Anstellung',
        // 'WorkHours' => 'Arbeitszeit pro Woche',
        // 'Skills' => 'Fähigkeiten',
        // 'Qualifications' => 'Qualifikationen',
        // 'EducationRequirements' => 'Anforderung Ausbildung',
        // 'Responsibilities' => 'Verantwortung',
        // 'ExperienceRequirements' => 'Anforderungen Erfahrung',
        // 'JobBenefits' => 'Vorteile (wir bieten...)',
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

        if ($page = $this->Parent()) {
            Requirements::add_i18n_javascript('silverstripe/cms: client/lang', false, true);
            $fields->insertAfter(
                SiteTreeURLSegmentField::create('URLSegment')
                    ->setURLPrefix($this->Parent()->getPage()->Link() . 'job/')
                    ->setDefaultURL($this->generateURLSegment()),
                'Title'
            );
        }

        if ($this->LastFor() == false) {
            $message = _t('Kraftausdruck\Models\JobPosting.expiredAlert', 'false');
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
            $TitleField->setDescription( _t('Kraftausdruck\Models\JobPosting.TitleCMSDesc', 'z.B. Projektleiter 100% (m/w/d)'));
        }

        if ($WorkHoursField = $fields->dataFieldByName('WorkHours')) {
            $WorkHoursField->setDescription(_t('Kraftausdruck\Models\JobPosting.WorkHoursDesc', 'z.B. 42 Stunden pro Woche'));
        }

        if ($SkillsField = $fields->dataFieldByName('Skills')) {
            $SkillsField->setDescription(_t('Kraftausdruck\Models\JobPosting.SkillsDesc', 'z.B. Englischkenntnisse Kommunikationsfähigkeiten'));
        }

        if ($QualificationsField = $fields->dataFieldByName('Qualifications')) {
            $QualificationsField->setDescription(_t('Kraftausdruck\Models\JobPosting.QualificationsDesc', 'Zertifikate z.B. CCNA LPI NBW'));
        }

        if ($EducationRequirementsField = $fields->dataFieldByName('EducationRequirements')) {
            $EducationRequirementsField->setDescription(_t('Kraftausdruck\Models\JobPosting.EducationRequirementsDesc', 'z.B. Lehre Hochschule HF/FH ETH UNI'));
        }

        if ($JobBenefitsField = $fields->dataFieldByName('JobBenefits')) {
            $JobBenefitsField->setDescription(_t('Kraftausdruck\Models\JobPosting.JobBenefitsDesc', 'z.B. 5 Wochen Ferien, flexible Arbeitszeiten'));
        }

        if ($ExperienceRequirementsField = $fields->dataFieldByName('ExperienceRequirements')) {
            $ExperienceRequirementsField->setDescription(_t('Kraftausdruck\Models\JobPosting.ExperienceRequirementsDesc', 'z.B. Führungserfahrung'));
        }

        if ($TextEditorField = $fields->dataFieldByName('Description')) {
            $TextEditorField->setRows(30);
            $TextEditorField->addExtraClass('stacked');
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
            $uploadField->setFolderName('jobs');
            $uploadField->setDescription(_t('Kraftausdruck\Models\JobPosting.HeaderImageDesc', '1:2.62 // 2600x993px'));
            $fields->insertAfter('Active', $uploadField, true);
        }

        if ($InseratuploadField = $fields->dataFieldByName('Inserat')) {
            $InseratuploadField->allowedExtensions = array('PDF', 'pdf');
            $InseratuploadField->setFolderName('jobs');
            $InseratuploadField->setDescription(_t('Kraftausdruck\Models\JobPosting.InseratDesc', 'PDF'));
        }

        return $fields;
    }

    // ValidThrough is not required but if set one year should be enough
    public function validate()
    {
        $result = parent::validate();
        if($this->ValidThrough > date('Y-m-d',strtotime('now + 1 year'))) {
            $result->addError('Das JobPosting sollte höchstens ein Jahr gültig sein.');
        }
        return $result;
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
//          ->workHours($this->WorkHours)
//          ->skills($this->TextAsArray($this->Skills))
//          ->qualifications($this->TextAsArray($this->Qualifications))
//          ->educationRequirements($this->TextAsArray($this->EducationRequirements))
//          ->jobBenefits($this->TextAsArray($this->JobBenefits))
//          ->responsibilities($this->TextAsArray($this->Responsibilities))
            ->industry($this->Industry)
//          ->occupationalCategory($this->OccupationalCategory)
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

        $schema->setProperty('@id', $this->AbsoluteLink());

        return $schema->toScript();
    }

    public function Parent()
    {
        if(ElementJobs::get()->count()) {
            $e = ElementJobs::get()->filter(['Primary' => 1])->first();
            if (!$e) {
                $e = ElementJobs::get()->first();
            }
            return $e;
        }
    }

    public function generateURLSegment()
    {
        $anchor = $this->URLSegment;

        if ($anchor == '') {
            $filter = new URLSegmentFilter();
            $anchor = $filter->filter($this->Title);
        }

        if ($this->ID && $this->ClassName::get()->filter(['URLSegment' => $this->URLSegment])->exclude('ID', $this->ID)->count() > 0) {
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
                $this->URLSegment
            );
        }
    }

    public function onAfterWrite()
    {
        if (!$this->URLSegment) {
            $this->URLSegment = $this->ID;
            $this->write();
        }
        if ($this->ClassName::get()
            ->filter(['URLSegment' => $this->URLSegment])
            ->exclude(['ID' => $this->ID])
            ->count())
        {
            $this->URLSegment .= '-' . $this->ID;
            $this->write();
        }

        parent::onAfterWrite();
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
        $id = $this->Parent()->getPage()->ID;
        $link = Versioned::get_by_stage(ElementPage::class, 'Live')->filter('ID', $id)->first()->Link();
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
            $html->setValue('<span style="color: red;">' . _t('Kraftausdruck\Models\JobPosting.expired', 'false') . '</span>');
            $datediff = $html;
        }
        return $datediff;
    }

    // sitemap.xml
    public function getGooglePriority()
    {
        return 1;
    }


    // Feedteaser
    public function link()
    {
        return $this->AbsoluteLink();
    }
}
