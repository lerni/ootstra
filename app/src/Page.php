<?php

namespace {

    use Kraftausdruck\Models\JobPosting;
    use Spatie\SchemaOrg\Schema;
    use App\Elements\ElementHero;
    use SilverStripe\Core\ClassInfo;
    use SilverStripe\Blog\Model\Blog;
    use SilverStripe\Forms\FieldList;
    use SilverStripe\ORM\ArrayList;
    use SilverStripe\Control\Director;
    use SilverStripe\CMS\Model\SiteTree;
    use SilverStripe\Security\Permission;
    use SilverStripe\SiteConfig\SiteConfig;
    use TractorCow\Fluent\State\FluentState;
    use SilverStripe\Blog\Model\BlogCategory;
    use SilverStripe\Forms\GridField\GridField;
    use SilverStripe\CMS\Controllers\RootURLController;
    use SilverStripe\Core\Manifest\ModuleResourceLoader;
    use SilverStripe\Forms\GridField\GridFieldDeleteAction;
    use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
    use SilverStripe\Blog\Admin\GridFieldCategorisationConfig;
    use SilverStripe\Blog\Model\BlogPost;
    use SilverStripe\Control\Controller;
    use SilverStripe\Forms\GridField\GridFieldAddExistingAutocompleter;

    class Page extends SiteTree
    {

        private static $has_one = [];

        private static $many_many = [
            'PageCategories' => BlogCategory::class
        ];

        private static $many_many_extraFields = [
            'PageCategories' => [
                'SortOrder' => 'Int'
            ]
        ];

        private static $table_name = 'Page';

        public function getCMSFields()
        {
            $this->beforeUpdateCMSFields(function (FieldList $fields) {
                $fields->removeByName('ExtraMeta');

                if (!Permission::check('ADMIN') && $this->IsHome()) {
                    $fields->removeByName('URLSegment');
                }

                if ($TextEditor = $fields->dataFieldByName('Content')) {
                    $TextEditor->setRows(40);
                    $TextEditor->addExtraClass('stacked');
                    $TextEditor->setAttribute('data-mce-body-class', $this->ShortClassName());
                }
            });

            $fields = parent::getCMSFields();

            if ($MetaToggle = $fields->fieldByName('Root.Main.Metadata')) {

                if ($MetaTitleField = $MetaToggle->fieldByName('MetaTitle')) {
                    $MetaTitleField->setTargetLength(60, 50, 60);
                    $MetaTitleField->setAttribute('placeholder', $this->DefaultMetaTitle());
                    $MetaTitleField->setRightTitle('Wird als Titel im Browsertab und für Suchmaschinen Resultate verwendet. Wichtig für SEO!');
                }

                if ($MetaDescriptionField = $MetaToggle->fieldByName('MetaDescription')) {
                    $MetaDescriptionField->setTargetLength(160, 100, 160);
                    $MetaDescriptionField->setAttribute('placeholder', $this->DefaultMetaDescription);
                    $MetaDescriptionField->setRightTitle('Wird in Suchmaschinen-Ergebnissen verwendet, wenn Länge passt und Relevanz gegeben ist; beeinflusst die SEO-Position kaum. Ansprechende Meta-Descripton (besonders die ersten ~55 Zeichen -> Sitelinks) beeinflussen die Klickrate jedoch stark.');
                }

                $fields->removeByName('Metadata');
                $fields->insertAfter('MenuTitle', $MetaToggle);
            }

            if ($this->ClassName != Blog::class) {
                $CatGFConfig = GridFieldCategorisationConfig::create(
                    15,
                    $this->PageCategories()->sort('Title'),
                    BlogCategory::class,
                    'PageCategories',
                    'BlogPosts'
                );

                $CatGFConfig->addComponents([
                    new GridFieldAddExistingAutocompleter('toolbar-header-right'),
                    new GridFieldDeleteAction(true)
                ]);

                // hack arround unsaved relations
                if ($this->isInDB()) {
                    $CatGFConfig->addComponent(new GridFieldOrderableRows('SortOrder'));
                }

                $categories = GridField::create(
                    'PageCategories',
                    _t('SilverStripe\Blog\Model\BlogPost.Categories', 'Categories'),
                    $this->PageCategories(),
                    $CatGFConfig
                );

                // $fields->addFieldToTab('Root.' . _t('SilverStripe\Blog\Model\BlogPost.Categories', 'Categories'), $categories);
            }

            return $fields;
        }

        public function DefaultMetaTitle()
        {
            if (!$this->MetaTitle) {
                return $this->Title . ' | ' . $this->getSiteConfig()->Title;
            }
        }

        public function DefaultMetaDescription()
        {
            if ($this->ClassName == 'SilverStripe\Blog\Model\BlogPost') {
                if ($this->Summary) {
                    $metaDescription = strip_tags($this->Summary);
                }
            }
            if ($this->MetaDescription) {
                $metaDescription = $this->MetaDescription;
            }
            if (!isset($metaDescription)) {
                $metaDescription = $this->SiteConfig->MetaDescription;
            }
            return $metaDescription;
        }

        //    public function getSettingsFields()
        //    {
        //        $this->beforeExtending('updateSettingsFields', function (FieldList $fields) {
        //        });
        //
        //        return parent::getSettingsFields();
        //    }

        // /**
        //  * Returns the controller class name for this page type. If a matching subclass of
        //  * PageController exists, use that. Otherwise default to the base namespaced controller.
        //  *
        //  * This is required as SiteTree::getControllerName() doesn't traverse sideways across
        //  * namespaces (i.e from \Model to \Control) when looking for a controller.
        //  *
        //  * @return string
        //  */
        // public function getControllerName()
        // {
        //     $current = static::class;
        //     $ancestry = ClassInfo::ancestry($current);
        //     $controller = null;
        //     while ($class = array_pop($ancestry)) {
        //         if ($class === self::class) {
        //             break;
        //         }
        //         if (class_exists($candidate = sprintf('%sController', $class))) {
        //             $controller = $candidate;
        //             break;
        //         }
        //         $candidate = sprintf('%sController', str_replace('\\Model\\', '\\Control\\', $class));
        //         if (class_exists($candidate)) {
        //             $controller = $candidate;
        //             break;
        //         }
        //     }
        //     if ($controller) {
        //         return $controller;
        //     }
        //     return PageController::class;
        // }

        // we use this in template & WYSIWYGs for css classes
        // similar function is on ElementExtension
        public function ShortClassName($lowercase = false)
        {

            $r = ClassInfo::shortName($this);

            if ($lowercase) {
                $r = strtolower($r);
            }
            return $r;
        }

        public function getDefaultOGTitle()
        {

            $title_return = $this->owner->getTitle();

            // JobPosting
            if (Controller::has_curr()) {
                $req = Controller::curr()->getRequest();
                if ($req->param('Action') == 'job' && $req->param('ID')) {
                    $URLSegment = $req->param('ID');
                    $job = JobPosting::get()->filter('URLSegment', $URLSegment)->first();;
                    if ($job->Description) {
                        $title_return = trim($job->Title);
                    }
                }
            }

            return $title_return;
        }

        public function getDefaultOGDescription()
        {
            $descreturn = '';

            // Use MetaDescription if set
            if ($this->MetaDescription) {
                $description = trim($this->MetaDescription);
                if (!empty($description)) {
                    $descreturn = $description;
                }
            }

            // In case of BlogPost use Summary it set
            if ($this->ClassName == 'SilverStripe\Blog\Model\BlogPost' && $this->Summary) {
                $description = trim($this->obj('Summary')->Summary(20, 5));
                if (!empty($description)) {
                    $descreturn = $description;
                }
            }

            // JobPosting
            if (Controller::has_curr()) {
                $req = Controller::curr()->getRequest();
                if ($req->param('Action') == 'job' && $req->param('ID')) {
                    $URLSegment = $req->param('ID');
                    $job = JobPosting::get()->filter('URLSegment', $URLSegment)->first();;
                    if ($job->Description) {
                        $descreturn = trim($job->obj('Description')->Summary(20, 5));
                    }
                }
            }

            if (!$descreturn) {
                // Fall back to Content
                if ($this->Content) {
                    $description = trim($this->obj('Content')->Summary(20, 5));
                    if (!empty($description)) {
                        $descreturn = $description;
                    }
                }
                if ($this->hasExtension('DNADesign\Elemental\Extensions\ElementalPageExtension')) {
                    $descreturn = trim(($this->obj('getElementsForSummary')->Summary(20, 5)));
                }
            }
            return $descreturn;
        }

        public function getDefaultOGImage()
        {
            $i = null;

            if ($this->hasExtension(ElementalPageExtension::class)) {
                if ($EH = $this->ElementalArea()->Elements()->filter('ClassName', ElementHero::class)->first()) {
                    if ($EH->Slides()->Count()) {
                        if ($SI = $EH->Slides()->Sort('SortOrder ASC')->first()) {
                            if ($SI->SlideImage->exists())
                                $i = $SI->SlideImage;
                        }
                    }
                }
            }

            // JobPosting
            if (Controller::has_curr()) {
                $req = Controller::curr()->getRequest();
                if ($req->param('Action') == 'job' && $req->param('ID')) {
                    $URLSegment = $req->param('ID');
                    $job = JobPosting::get()->filter('URLSegment', $URLSegment)->first();;
                    if ($job->HeaderImage->exists()) {
                        $i = $job->HeaderImage();
                    }
                }
            }

            if ($i != null) {
                return $i->FocusFillMax(1200, 630);
            } elseif (file_exists(BASE_PATH . '/public/icon-512.png')) {
                // Fallback to website's touch-icon
                return rtrim(Director::absoluteBaseURL(), '/') . ModuleResourceLoader::resourceURL('public/icon-512.png');
            }
        }

        public function Childrenexcluded($set = '')
        {

            $conf = $this->config()->get('Childrenexcluded');

            if ($set != '') {
                if (array_key_exists($set, $conf)) {
                    $exclude = $conf["$set"];
                }
            } elseif (is_array($conf) && array_key_exists('default', $conf)) {
                $exclude = $conf['default'];
            }

            $children = $this->Children();

            if (isset($exclude) && is_array($exclude)) {
                $children = $children->exclude('ClassName', $exclude);
            }

            return $children;
        }

        public function MyBaseURLForLocale()
        {
            if (class_exists('TractorCow\Fluent\Extension\FluentExtension')) {
                $baseURL = $this->BaseURLForLocale(FluentState::singleton()->getLocale());
            } else {
                $baseURL = Director::baseURL();
            }
            return $baseURL;
        }

        public function hasHero()
        {
            if ($this->hasExtension('DNADesign\Elemental\Extensions\ElementalPageExtension')) {
                if ($this->ElementalArea()->Elements()->Count() && $this->ElementalArea()->Elements()->first()->ClassName == 'App\Elements\ElementHero') {
                    return true;
                }
                if ($this->ElementalArea()->Elements()->Count() && $this->ElementalArea()->Elements()->first()->ClassName == 'DNADesign\ElementalVirtual\Model\ElementVirtual') {
                    if ($this->ElementalArea()->Elements()->first()->LinkedElement()->ClassName == 'App\Elements\ElementHero') {
                        return true;
                    }
                }
            }
        }

        public function CategoriesWithState()
        {
            // $Categories = BlogCategory::get();
            if ($this->owner->ClassName == BlogPost::class) {
                $Categories = $this->owner->Parent()->Categories();
                $currentCategories = $this->owner->Categories()->Column('ID');
            } elseif ($this->owner->ClassName == Blog::class) {
                $Categories = $this->owner->Categories();
                if (Controller::curr()->getCurrentCategory()) {
                    $currentCategories['0'] = Controller::curr()->getCurrentCategory()->ID;
                } else {
                    $currentCategories = [];
                }
            } else {
                $Categories = [];
            }

            $r = ArrayList::create();
            foreach ($Categories as $Cat) {
                if (in_array($Cat->ID, $currentCategories)) {
                    $Cat->CustomLinkingMode = 'current';
                } else {
                    $Cat->CustomLinkingMode = 'link';
                }
                $r->push($Cat);
            }
            return $r;
        }

        public function LocalBusinessSchema()
        {

            $siteConfig = SiteConfig::current_site_config();

            $schemaOrganisation = Schema::organization();

            $schemaOrganisation
                ->name($siteConfig->Title)
                ->description($siteConfig->MetaDescription)
                ->url($siteConfig->CanonicalDomain)
                ->logo(rtrim(Director::absoluteBaseURL(), '/') . ModuleResourceLoader::resourceURL('public/icon-512.png'));

            if ($siteConfig->Locations()->Count()) {

                $locations = [];
                $i = 0;
                foreach ($siteConfig->Locations() as $location) {

                    $country = strtoupper($location->Country);

                    $PushLocation = Schema::postalAddress()
                        ->email($location->EMail)
                        ->streetAddress($location->Address)
                        ->postalCode($location->PostalCode)
                        ->addressLocality($location->Town)
                        ->postOfficeBoxNumber($location->PostOfficeBoxNumber)
                        ->telephone($location->Telephone)
                        ->addressRegion($location->AddressRegion)
                        ->addressCountry(Schema::Country()
                            ->name($country));


                    $locations[$i] = Schema::LocalBusiness()
                        ->name($location->Title)
                        ->address($PushLocation);

                    if ($location->OpeningHours) {
                        // remove empty newlines
                        $ohString = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $location->OpeningHours);
                        $openingHoursLines = explode(PHP_EOL, $ohString);
                        $locations[$i]->openingHours($openingHoursLines);
                    }

                    if ($location->GeoPoint()->exists()) {
                        $PushGeo = Schema::geoCoordinates()
                            ->latitude($location->GeoPoint()->Latitude)
                            ->longitude($location->GeoPoint()->Longitude);

                        // default has map lat/lng based - 'll be overriden if $location->PointURL exists
                        $locations[$i]->hasMap($location->GeoPoint()->GMapLatLngLink());
                        $locations[$i]->geo($PushGeo);
                    }

                    if ($location->PointURL) {
                        $locations[$i]->hasMap($location->PointURL);
                    }

                    if ($siteConfig->DefaultHeaderImage()->exists()) {
                        $locations[$i]->image(rtrim(Director::absoluteBaseURL(), '/') . $siteConfig->DefaultHeaderImage()->Link());
                    }

                    $i++;
                }

                $schemaOrganisation->location($locations);
            }
            if ($siteConfig->SocialLinks()->filter('sameAs', 1)->Count()) {
                $sameAsLinks = $siteConfig->SocialLinks()->filter('sameAs', 1)->Column('Url');
                $schemaOrganisation->sameAs($sameAsLinks);
            }

            if ($siteConfig->DefaultHeaderImage()->exists()) {
                $schemaOrganisation->image(rtrim(Director::absoluteBaseURL(), '/') . $siteConfig->DefaultHeaderImage()->Link());
            }

            return $schemaOrganisation->toScript();
        }

        public function BreadcrumbListSchema()
        {
            $pageObjs = [];
            $i = 0;
            $breadcrumbs = $this->getBreadcrumbItems();
            $bCount = $this->getBreadcrumbItems()->count();
            foreach ($breadcrumbs as $item) {

                $pageObjs[$i] = Schema::listItem()
                    ->position((int)$i + 1)
                    ->name($item->Title)
                    ->setProperty('@id', Director::absoluteBaseURL() . ltrim($item->Link(), '/'));
                $i++;
            }

            $breadcrumbList = Schema::breadcrumbList()
                ->itemListElement($pageObjs);

            return $breadcrumbList->toScript();
        }

        public function IsHome()
        {
            if ($this->URLSegment == RootURLController::get_homepage_link()) {
                return true;
            }
        }

        // current year for copyright in footer
        public function CurrentYear()
        {
            return date("Y");
        }

        // link without parameter
        public function LinkNoParam()
        {
            if (Controller::has_curr()) {
                $req = Controller::curr()->getRequest();
                $url = $req->getURL(FALSE);
                return $url;
            }
        }
    }
}
