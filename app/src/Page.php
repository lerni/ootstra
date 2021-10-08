<?php

namespace {

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
    use SilverStripe\Forms\GridField\GridField;
    use SilverStripe\CMS\Controllers\RootURLController;
    use SilverStripe\Core\Manifest\ModuleResourceLoader;
    use SilverStripe\Forms\GridField\GridFieldDeleteAction;
    use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
    use SilverStripe\Blog\Admin\GridFieldCategorisationConfig;
    use SilverStripe\Blog\Model\BlogPost;
    use SilverStripe\Control\Controller;
    use SilverStripe\Forms\GridField\GridFieldAddExistingAutocompleter;
    use DNADesign\Elemental\Extensions\ElementalPageExtension;

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

        // $controller_name 'll make blog fail - so don't!
        // private static $controller_name  = PageController::class;

        public function getCMSFields()
        {
            $this->beforeUpdateCMSFields(function (FieldList $fields) {
                $fields->removeByName(['ExtraMeta']);

                if (!Permission::check('ADMIN') && $this->IsHome()) {
                    $fields->removeByName('URLSegment');
                }

                if ($TextEditor = $fields->dataFieldByName('Content')) {
                    $TextEditor->setRows(30);
                    $TextEditor->addExtraClass('stacked');
                    $TextEditor->setAttribute('data-mce-body-class', $this->ShortClassName());
                }
            });

            $fields = parent::getCMSFields();

            if ($MetaToggle = $fields->fieldByName('Root.Main.Metadata')) {

                if ($MetaTitleField = $MetaToggle->fieldByName('MetaTitle')) {
                    $MetaTitleField->setTargetLength(60, 50, 60);
                    $MetaTitleField->setAttribute('placeholder', $this->DefaultMetaTitle());
                    $MetaTitleField->setRightTitle(_t('\Page.MetaTitleRightTitle', 'Used as a title in the browser tab and for search engine results. Important for SEO!'));
                }

                if ($MetaDescriptionField = $MetaToggle->fieldByName('MetaDescription')) {
                    if (!$MetaDescriptionField->isReadonly()) {
                        $MetaDescriptionField->setTargetLength(160, 100, 160);
                        $MetaDescriptionField->setAttribute('placeholder', $this->DefaultMetaDescription());
                        $MetaDescriptionField->setRightTitle(_t('\Page.MetaDescriptionRightTitle', 'Used in search engine results when length fits and relevance is given; hardly affects the SEO position. Appealing meta-descriptions (especially the first ~ 55 characters -> sitelinks) have a strong influence on the click rate.'));
                    }
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
                $description = trim($this->obj('Summary')->Summary(20));
                if (!empty($description)) {
                    $descreturn = $description;
                }
            }

            // JobPosting
            if (Controller::has_curr()) {
                $req = Controller::curr()->getRequest();
                if ($req->param('Action') == 'job' && $req->param('ID')) {
                    $URLSegment = $req->param('ID');
                    $job = JobPosting::get()->filter('URLSegment', $URLSegment)->first();
                    if ($job && $job->Description) {
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

        // $origin = 1 -> not resized
        public function getDefaultOGImage($origin = 0)
        {
            $i = null;

            if ($this->hasExtension(ElementalPageExtension::class)) {
                if ($EH = $this->ElementalArea()->Elements()->filter('ClassName', ElementHero::class)->first()) {
                    if ($EH->Slides()->Count()) {
                        if ($SI = $EH->Slides()->Sort('SortOrder ASC')->first()) {
                            if ($SI->SlideImage->exists()) {
                                $i = $SI->SlideImage;
                            }
                        }
                    }
                }
            }

            if ($this->ClassName == Blog::class) {
                if ($this->Slides()->Count()) {
                    if ($SI = $this->Slides()->Sort('SortOrder ASC')->first()) {
                        if ($SI->SlideImageID) {
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
                    return $i->FocusFillMax(1200, 630);
                } else {
                    return $i;
                }
            } elseif (file_exists(BASE_PATH . '/public/icon-512.png') && !$origin) {
                // Fallback to website's touch-icon
                return rtrim(Director::absoluteBaseURL(), '/') . ModuleResourceLoader::resourceURL('public/icon-512.png');
            }
        }

        public function Childrenexcluded($set = 'default')
        {

            $conf = $this->config()->get('childrenexcluded');

            if (is_array($conf)) {
                if ($set != '' && array_key_exists($set, $conf)) {
                    $exclude = $conf["$set"];
                } elseif (array_key_exists('default', $conf)) {
                    $exclude = $conf['default'];
                }
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
            } elseif ($this->ClassName == 'SilverStripe\CMS\Model\VirtualPage' && $this->CopyContentFrom()->hasExtension('DNADesign\Elemental\Extensions\ElementalPageExtension')) {
                if ($this->CopyContentFrom()->ElementalArea()->Elements()->Count() && $this->CopyContentFrom()->ElementalArea()->Elements()->first()->ClassName == 'App\Elements\ElementHero') {
                    return true;
                }
            }
        }

        // overwriting this form GoogleSitemapSiteTreeExtension,
        // since we do not want to get related pics in automatically
        public function ImagesForSitemap()
        {
            $IDList = [];
            if ($this->hasExtension(ElementalPageExtension::class)) {
                // Images from Heros
                if ($elementHeros = $this->ElementalArea()->Elements()->filter('ClassName', ElementHero::class)) {
                    foreach ($elementHeros as $hero) {
                        if ($hero->Slides()->count()) {
                            if ($slides = $hero->Slides()->Sort('SortOrder ASC')) {
                                foreach ($slides as $slide) {
                                    if ($slide->SlideImage->exists()) {
                                        array_push($IDList, $slide->SlideImageID);
                                    }
                                }
                            }
                        }
                    }
                }
                // Images from ElementGallery
                if ($elementGallery = $this->ElementalArea()->Elements()->filter('ClassName', ElementGallery::class)) {
                    foreach ($elementGallery as $gallery) {
                        if ($gallery->Items()->count()) {
                            if ($images = $gallery->Items()) {
                                foreach ($images as $image) {
                                    if ($image->exists()) {
                                        $list->push($image);
                                        $IDList = array_push($IDList, $image->ID);
                                    }
                                }
                            }
                        }
                    }
                }
            }
            $IDList = array_unique($IDList);
            if (count($IDList)) {
                return Image::get()->filter(['ID' => $IDList]);
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

        public function getHomePage()
        {
            $defaultHomepage = RootURLController::config()->get('default_homepage_link');
            return SiteTree::get()->filter('URLSegment', $defaultHomepage)->first();
        }
    }
}
