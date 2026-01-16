<?php

use App\Elements\ElementHero;
use App\Elements\ElementGallery;
use SilverStripe\Blog\Model\Blog;
use SilverStripe\Forms\FieldList;
use SilverStripe\Control\Director;
use SilverStripe\Security\Security;
use SilverStripe\TagField\TagField;
use JonoM\ShareCare\ShareCareFields;
use Kraftausdruck\Models\JobPosting;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Control\Controller;
use SilverStripe\Blog\Model\BlogPost;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Security\Permission;
use SilverStripe\Model\List\ArrayList;
use SilverStripe\CMS\Model\VirtualPage;
use TractorCow\Fluent\State\FluentState;
use SilverStripe\Blog\Model\BlogCategory;
use SilverStripe\CMS\Model\RedirectorPage;
use SilverStripe\CMS\Controllers\RootURLController;
use DNADesign\ElementalVirtual\Model\ElementVirtual;
use SilverStripe\Core\Manifest\ModuleResourceLoader;
use DNADesign\Elemental\Extensions\ElementalPageExtension;

class Page extends SiteTree
{

    private static $db = [
        'HideSubNavi' => 'Boolean'
    ];

    private static $has_one = [];

    private static $many_many = [
        'PageCategories' => BlogCategory::class
    ];

    private static $table_name = 'Page';

    // $controller_name 'll make blog fail - so don't!
    // private static $controller_name  = PageController::class;

    public function getCMSFields()
    {
        $this->beforeUpdateCMSFields(function (FieldList $fields): void {
            $fields->removeByName([
                'ExtraMeta',
                'HideSubNavi'
            ]);

            if (!Permission::check('ADMIN') && $this->isHomePage()) {
                $fields->removeByName(['URLSegment']);
            }

            if ($TextEditor = $fields->dataFieldByName('Content')) {
                $TextEditor->setRows(30);
                $TextEditor->getEditorConfig()->setOption('body_class', 'typography ' . $this->ShortClassName($this, true));
            }
        });

        $fields = parent::getCMSFields();

        if ($MetaToggle = $fields->fieldByName('Root.Main.Metadata')) {

            if ($MetaTitleField = $MetaToggle->fieldByName('MetaTitle')) {
                $MetaTitleField->setTargetLength(60, 50, 60);
                $MetaTitleField->setAttribute('placeholder', $this->DefaultMetaTitle());
                $MetaTitleField->setRightTitle(_t('\Page.MetaTitleRightTitle', 'Used as a title in the browser and for search engine results. Important for SEO!'));
            }

            if (($MetaDescriptionField = $MetaToggle->fieldByName('MetaDescription')) && !$MetaDescriptionField->isReadonly()) {
                $MetaDescriptionField->setTargetLength(150, 100, 160);
                $MetaDescriptionField->setAttribute('placeholder', $this->DefaultMetaDescription());
                $MetaDescriptionField->setRightTitle(_t('\Page.MetaDescriptionRightTitle', 'Used in search engine results when length fits and relevance is given; hardly affects SEO position. Appealing meta-descriptions (especially the first ~ 55 characters -> sitelinks) have a strong influence on the click rate.'));
            }

            $fields->removeByName('Metadata');
            $fields->insertAfter('MenuTitle', $MetaToggle);
        }

        if (
            $this->ClassName != Blog::class &&
            $this->ClassName != BlogPost::class &&
            $this->ClassName != RedirectorPage::class
        ) {
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

    public function DefaultMetaTitle()
    {
        $parts = [
            $this->MetaTitle ?: $this->Title,
            $this->getSiteConfig()->Title
        ];
        return implode(' | ', array_filter($parts));
    }

    public function DefaultMetaDescription()
    {
        if ($this->ClassName == 'SilverStripe\Blog\Model\BlogPost' && $this->Summary) {
            $metaDescription = strip_tags($this->Summary);
        }
        if ($this->MetaDescription) {
            $metaDescription = $this->MetaDescription;
        }
        if (!isset($metaDescription)) {
            $metaDescription = $this->getSiteConfig()->MetaDescription;
        }
        return $metaDescription;
    }

    public function getSettingsFields()
    {
        $this->beforeExtending('updateSettingsFields', function (FieldList $fields) {
            $fields->addFieldToTab(
                'Root.Settings',
                CheckboxField::create(
                    'HideSubNavi',
                    _t(__CLASS__ . '.HIDESUBNAVI', 'Hide sub navigation')
                ),
                'ShowInSearch'
            );
        });

        return parent::getSettingsFields();
    }

    public function getDefaultOGDescription($limitChar = 0, $limitWordCount = 25)
    {
        $descreturn = null;

        // In case of BlogPost use Summary it set
        if ($this->ClassName == BlogPost::class && $this->Summary) {
            $description = trim($this->obj('Summary')->Summary($limitWordCount, '...', 5));
            if (!empty($description)) {
                $descreturn = strip_tags($description);
            }
        }

        // JobPosting
        $controller = Controller::curr();
        if ($controller) {
            $req = $controller->getRequest();
            if ($req->param('Action') == 'job' && $req->param('ID')) {
                $URLSegment = $req->param('ID');
                $job = JobPosting::get()->filter('URLSegment', $URLSegment)->first();
                if ($job && $job->MetaDescription) {
                    $descreturn = trim($job->MetaDescription);
                }
            }
        }

        // Use MetaDescription if set
        if ($this->MetaDescription) {
            $description = trim($this->obj('MetaDescription')->Summary($limitWordCount, '...', 5));
            if (!empty($description)) {
                $descreturn = $description;
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
            if ($this->hasExtension(ElementalPageExtension::class)) {
                $descreturn = trim(($this->obj('getElementsForSummary')->Summary($limitWordCount, 5)));
            }
        }

        // if still empty, use SiteConfig MetaDescription
        if (!$descreturn) {
            $descreturn = $this->getSiteConfig()->MetaDescription;
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

        // OGImageCustom
        if ($this->hasExtension(ShareCareFields::class) && $this->OGImageCustom->exists()) {
            $i = $this->OGImageCustom;
        // first image in page that is indexed
        } elseif ($this->ImagesForSitemap() && $this->ImagesForSitemap()->count()) {
            if ($this->ImagesForSitemap()->first()->exists()) {
                $i = $this->ImagesForSitemap()->first();
            }
        }

        if ($i != null) {
            if (!$origin) {
                return $i->FocusFillMax(1200, 630);
            }
            return $i;
        }

        if (file_exists(BASE_PATH . '/public/icon-512.png') && !$origin) {
            // Fallback to website's touch-icon
            return rtrim(Director::absoluteBaseURL(), '/') . ModuleResourceLoader::resourceURL('public/icon-512.png');
        }
    }

    public function Childrenexcluded($set = 'default', $all = 0)
    {

        $conf = $this->config()->get('childrenexcluded');

        if (is_array($conf)) {
            if ($set != '' && array_key_exists($set, $conf)) {
                $exclude = $conf[$set];
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
            if ($this->ElementalArea()->Elements()->Count() && $this->ElementalArea()->Elements()->first()->ClassName == ElementVirtual::class && $this->ElementalArea()->Elements()->first()->LinkedElement()->ClassName == ElementHero::class) {
                return true;
            }
        } elseif ($this->ClassName == VirtualPage::class && $this->CopyContentFrom()->hasExtension(ElementalPageExtension::class)) {
            if ($this->CopyContentFrom()->ElementalArea()->Elements()->Count() && $this->CopyContentFrom()->ElementalArea()->Elements()->first()->ClassName == ElementHero::class) {
                return true;
            }
        }
        return null;
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

    public function getHomePage()
    {
        $defaultHomepage = RootURLController::config()->get('default_homepage_link');
        return SiteTree::get()->filter('URLSegment', $defaultHomepage)->first();
    }

    // overwriting from GoogleSitemapSiteTreeExtension,
    // since we do not want to get related pics in automatically
    public function ImagesForSitemap()
    {
        $siteMapImages = ArrayList::create();
        if ($this->hasExtension(ElementalPageExtension::class)) {
            // Images from Heroes
            if ($elementHeros = $this->ElementalArea()->Elements()->filter('ClassName', ElementHero::class)) {
                foreach ($elementHeros as $hero) {
                    if (!$hero->Slides()->count()) {
                        continue;
                    }
                    if (!$hero->SitemapImageExpose) {
                        continue;
                    }
                    if (!$slides = $hero->Slides()->Sort('SortOrder ASC')) {
                        continue;
                    }
                    foreach ($slides as $slide) {
                        if ($slide->SlideImage->exists() && !$slide->SlideImage->NoFileIndex()) {
                            $siteMapImages->push($slide->SlideImage());
                        }
                    }
                }
            }
            // Images from ElementGallery
            if ($elementGallery = $this->ElementalArea()->Elements()->filter('ClassName', ElementGallery::class)) {
                foreach ($elementGallery as $gallery) {
                    if (!$gallery->Items()->count()) {
                        continue;
                    }
                    if (!$gallery->SitemapImageExpose) {
                        continue;
                    }
                    if (!$images = $gallery->Items()) {
                        continue;
                    }
                    foreach ($images as $image) {
                        if ($image->exists() && !$image->NoFileIndex()) {
                            $siteMapImages->push($image);
                        }
                    }
                }
            }
        }
        if ($siteMapImages->count()) {
            return $siteMapImages->removeDuplicates('ID');
        }
    }

    public function IsPreview()
    {
        $controller = Controller::curr();
        if (!$controller) {
            return;
        }
        $request = $controller->getRequest();
        if ($request->getVar('CMSPreview')) {
            return true;
        } else {
            return false;
        }
    }

    public function IsMember() {
		if($member = Security::getCurrentUser()) {
			return $member;
		}
		return false;
	}
}
