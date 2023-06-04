<?php

namespace {

    use SilverStripe\CMS\Model\VirtualPage;
    use SilverStripe\TagField\TagField;
    use SilverStripe\Assets\Image;
    use App\Elements\ElementHero;
    use App\Elements\ElementGallery;
    use JonoM\ShareCare\ShareCareFields;
    use Kraftausdruck\Models\JobPosting;
    use SilverStripe\Core\ClassInfo;
    use SilverStripe\Blog\Model\Blog;
    use SilverStripe\Forms\FieldList;
    use SilverStripe\ORM\ArrayList;
    use SilverStripe\Control\Director;
    use SilverStripe\CMS\Model\SiteTree;
    use SilverStripe\Security\Permission;
    use TractorCow\Fluent\State\FluentState;
    use SilverStripe\Blog\Model\BlogCategory;
    use SilverStripe\CMS\Controllers\RootURLController;
    use SilverStripe\Core\Manifest\ModuleResourceLoader;
    use SilverStripe\Blog\Model\BlogPost;
    use SilverStripe\Control\Controller;
    use DNADesign\Elemental\Extensions\ElementalPageExtension;
    use DNADesign\ElementalVirtual\Model\ElementVirtual;

    class Page extends SiteTree
    {

        private static $has_one = [];

        private static $many_many = [
            'PageCategories' => BlogCategory::class
        ];

        private static $table_name = 'Page';

        // $controller_name 'll make blog fail - so don't!
        // private static $controller_name  = PageController::class;

        public function getCMSFields()
        {
            $this->beforeUpdateCMSFields(function (FieldList $fields) {
                $fields->removeByName(['ExtraMeta']);

                if (!Permission::check('ADMIN') && $this->IsHome()) {
                    $fields->removeByName(['URLSegment']);
                }

                if ($TextEditor = $fields->dataFieldByName('Content')) {
                    $TextEditor->setRows(30);
                    $TextEditor->setAttribute('data-mce-body-class', $this->ShortClassName($this));
                }
            });

            $fields = parent::getCMSFields();

            if ($MetaToggle = $fields->fieldByName('Root.Main.Metadata')) {

                if ($MetaTitleField = $MetaToggle->fieldByName('MetaTitle')) {
                    $MetaTitleField->setTargetLength(60, 50, 60);
                    $MetaTitleField->setAttribute('placeholder', $this->DefaultMetaTitle());
                    $MetaTitleField->setRightTitle(_t('\Page.MetaTitleRightTitle', 'Used as a title in the browser and for search engine results. Important for SEO!'));
                }

                if ($MetaDescriptionField = $MetaToggle->fieldByName('MetaDescription')) {
                    if (!$MetaDescriptionField->isReadonly()) {
                        $MetaDescriptionField->setTargetLength(150, 100, 160);
                        $MetaDescriptionField->setAttribute('placeholder', $this->DefaultMetaDescription());
                        $MetaDescriptionField->setRightTitle(_t('\Page.MetaDescriptionRightTitle', 'Used in search engine results when length fits and relevance is given; hardly affects SEO position. Appealing meta-descriptions (especially the first ~ 55 characters -> sitelinks) have a strong influence on the click rate.'));
                    }
                }

                $fields->removeByName('Metadata');
                $fields->insertAfter('MenuTitle', $MetaToggle);
            }

            if ($this->ClassName != Blog::class && $this->ClassName != BlogPost::class) {

                $CategoryField = TagField::create(
                    'PageCategories',
                    _t('SilverStripe\Blog\Model\Blog.Categories', 'Categories'),
                    BlogCategory::get(),
                    $this->PageCategories()
                );

                $fields->addFieldToTab('Root.Main', $CategoryField, 'Metadata');
            }

            return $fields;
        }

        // todo: relay on get magic or not?
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

        // we use this in template & WYSIWYGs for css classes
        // todo: similar function is on ElementExtension
        public function ShortClassName($obj, $lowercase = false)
        {
            if (!is_object($obj)) {
                $r = ClassInfo::shortName($this);
            } else {
                $r = ClassInfo::shortName($obj);
            }

            if ($lowercase) {
                $r = strtolower($r);
            }
            return $r;
        }

        public function getDefaultOGTitle()
        {

            $title_return = $this->getTitle();

            // JobPosting
            if (Controller::has_curr()) {
                $req = Controller::curr()->getRequest();
                if ($req->param('Action') == 'job' && $req->param('ID')) {
                    $URLSegment = $req->param('ID');
                    $job = JobPosting::get()->filter('URLSegment', $URLSegment)->first();
                    if ($job && $job->Title) {
                        $title_return = trim($job->Title);
                    }
                }
            }

            return $title_return;
        }

        public function getDefaultOGDescription($limitChar = 0, $limitWordCount = 20)
        {
            $descreturn = '';

            // Use MetaDescription if set
            if ($this->MetaDescription) {
                $description = trim($this->obj('MetaDescription')->Summary($limitWordCount, 5));
                if (!empty($description)) {
                    $descreturn = $description;
                }
            }

            // In case of BlogPost use Summary it set
            if ($this->ClassName == 'SilverStripe\Blog\Model\BlogPost' && $this->Summary) {
                $description = trim($this->obj('Summary')->Summary($limitWordCount, 5));
                if (!empty($description)) {
                    $descreturn = strip_tags($description);
                }
            }

            // JobPosting
            if (Controller::has_curr()) {
                $req = Controller::curr()->getRequest();
                if ($req->param('Action') == 'job' && $req->param('ID')) {
                    $URLSegment = $req->param('ID');
                    $job = JobPosting::get()->filter('URLSegment', $URLSegment)->first();
                    if ($job && $job->MetaDescription) {
                        $descreturn = trim($job->MetaDescription);
                    }
                }
            }

            if (!$descreturn) {
                // Fall back to Content
                if ($this->Content) {
                    $description = trim($this->obj('Content')->Summary($limitWordCount, 5));
                    if (!empty($description)) {
                        $descreturn = $description;
                    }
                }
                if ($this->hasExtension('DNADesign\Elemental\Extensions\ElementalPageExtension')) {
                    $descreturn = trim(($this->obj('getElementsForSummary')->Summary($limitWordCount, 5)));
                }
            }

            if ($limitChar && strlen($descreturn) > $limitChar) {
                $descreturn = substr($descreturn, 0, $limitChar);
            }

            return $descreturn;
        }

        // $origin = 1 -> not resized
        public function getDefaultOGImage($origin = 0)
        {
            $i = null;

            if ($this->ImagesForSitemap() && $this->ImagesForSitemap()->count()) {
                $i = $this->ImagesForSitemap()->first();
            }

            if ($this->ClassName == Blog::class) {
                if ($this->Slides()->Count()) {
                    if ($SI = $this->Slides()->Sort('SortOrder ASC')->first()) {
                        if ($SI->SlideImage->exists()) {
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
                    $job = JobPosting::get()->filter('URLSegment', $URLSegment)->first();
                    if ($job && $job->HeaderImage->exists()) {
                        $i = $job->HeaderImage();
                    }
                }
            }

            // OGImageCustom
            if ($this->hasExtension(ShareCareFields::class)) {
                if ($this->OGImageCustom->exists()) {
                    $i = $this->OGImageCustom;
                }
            }

            if ($i != null) {
                if (!$origin) {
                    return ($i->getWidth() > 1200) ? $i->scaleWidth(1200) : $i;
                } else {
                    return $i;
                }
            } elseif (file_exists(BASE_PATH . '/public/icon-512.png') && !$origin) {
                // Fallback to website's touch-icon
                return rtrim(Director::absoluteBaseURL(), '/') . ModuleResourceLoader::resourceURL('public/icon-512.png');
            }
        }

        public function Childrenexcluded($set = 'default', $all = 0)
        {

            $conf = $this->config()->get('childrenexcluded');

            if (is_array($conf)) {
                if ($set != '' && array_key_exists($set, $conf)) {
                    $exclude = $conf["$set"];
                } elseif (array_key_exists('default', $conf)) {
                    $exclude = $conf['default'];
                }
            }

            if ($all) {
                $children = $this->AllChildren();
            } else {
                $children = $this->Children();
            }

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
            if ($this->hasExtension(ElementalPageExtension::class)) {
                if ($this->ElementalArea()->Elements()->Count() && $this->ElementalArea()->Elements()->first()->ClassName == ElementHero::class) {
                    return true;
                }
                if ($this->ElementalArea()->Elements()->Count() && $this->ElementalArea()->Elements()->first()->ClassName == ElementVirtual::class) {
                    if ($this->ElementalArea()->Elements()->first()->LinkedElement()->ClassName == ElementHero::class) {
                        return true;
                    }
                }
            } elseif($this->ClassName == VirtualPage::class && $this->CopyContentFrom()->hasExtension(ElementalPageExtension::class))
            {
                if ($this->CopyContentFrom()->ElementalArea()->Elements()->Count() && $this->CopyContentFrom()->ElementalArea()->Elements()->first()->ClassName == ElementHero::class) {
                    return true;
                }
            }
        }

        public function CategoriesWithState()
        {
            $Categories = [];
            $currentCategories = [];

            if ($this->ClassName == BlogPost::class) {
                $Categories = $this->Parent()->Categories();
                $currentCategories = $this->Categories()->Column('ID');
            } elseif ($this->ClassName == Blog::class) {
                $Categories = $this->Categories();
                if (method_exists(Controller::curr(), 'getCurrentCategory') && Controller::curr()->getCurrentCategory()) {
                    $currentCategories['0'] = Controller::curr()->getCurrentCategory()->ID;
                }
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

        // link without parameter
        public function LinkNoParam()
        {
            if (Controller::has_curr()) {
                $req = Controller::curr()->getRequest();
                $url = $req->getURL(FALSE);
                return $url;
            }
        }

        public function getHomePage()
        {
            $defaultHomepage = RootURLController::config()->get('default_homepage_link');
            return SiteTree::get()->filter('URLSegment', $defaultHomepage)->first();
        }
    }
}
