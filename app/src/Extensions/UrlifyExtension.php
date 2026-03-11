<?php

namespace App\Extensions;

use App\Models\Perso;
use Spatie\SchemaOrg\Schema;
use App\Models\SlugHolderPage;
use SilverStripe\View\SSViewer;
use SilverStripe\Core\Extension;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\Model\ArrayData;
use SilverStripe\Control\Director;
use SilverStripe\View\Requirements;
use SilverStripe\Control\Controller;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Model\List\ArrayList;
use SilverStripe\Forms\ToggleCompositeField;
use SilverStripe\View\Parsers\URLSegmentFilter;
use SilverStripe\CMS\Controllers\RootURLController;
use SilverStripe\CMS\Forms\SiteTreeURLSegmentField;

// Unifies URL management for DataObjects that are managed via a SlugHolderPage in the CMS.

class UrlifyExtension extends Extension
{
    private static array $slugHolderCache = [];

    private static $db = [
        'Sort' => 'Int',
        'Title' => 'Varchar',
        'URLSegment' => 'Varchar',
        'MetaTitle' => 'Varchar',
        'MetaDescription' => 'Text',
    ];

    private static $indexes = [
        'URLSegment' => true,
    ];

    private static $defaults = [
        'URLSegment' => 'new-item',
    ];

    public function fieldLabels($includerelations = true)
    {
        $labels = parent::fieldLabels($includerelations);

        $labels['Title'] = _t(__CLASS__ . '.TITLE', 'Title');
        $labels['MetaTitle'] = _t(__CLASS__ . '.METATITLE', 'Meta Title');
        $labels['MetaDescription'] = _t(__CLASS__ . '.METADESCRIPTION', 'Meta Description');

        return $labels;
    }

    public function onAfterPopulateDefaults()
    {
        $this->getOwner()->Title = _t(self::class . '.DefaultTitle', 'New item');
        // todo DatePosted is not for all
        $this->getOwner()->DatePosted = date('Y-m-d');
    }

    public function updateCMSFields(FieldList $fields)
    {
        $fields->removeByName([
            'Sort',
            'MetaTitle',
            'MetaDescription',
        ]);

        $MetaToggle = ToggleCompositeField::create(
            'Metadata',
            _t(__CLASS__.'.MetadataToggle', 'Metadata'),
            [
                $MetaTitleField = new TextField('MetaTitle'),
                $MetaDescriptionField = new TextareaField('MetaDescription'),
            ],
        )->setHeadingLevel(4);

        $MetaTitleField->setTargetLength(60, 50, 60);
        $MetaTitleField->setAttribute('placeholder', $this->getOwner()->DefaultMetaTitle());
        $MetaTitleField->setRightTitle(_t('\Page.MetaTitleRightTitle', 'Wird als Titel im Browsertab und für Suchmaschinen Resultate verwendet. Wichtig für SEO!'));

        $MetaDescriptionField->setTargetLength(160, 100, 160);
        $MetaDescriptionField->setAttribute('placeholder', $this->getOwner()->DefaultMetaDescription());
        $MetaDescriptionField->setRightTitle(_t('\Page.MetaDescriptionRightTitle', 'Wird in Suchmaschinen-Ergebnissen verwendet, wenn Länge passt und Relevanz gegeben ist; beeinflusst die SEO-Position kaum. Ansprechende Meta-Descripton (besonders die ersten ~55 Zeichen -> Sitelinks) beeinflussen die Klickrate jedoch stark.'));

        $fields->insertAfter(
            'Title',
            $MetaToggle,
        );

        if ($page = $this->getOwner()->Parent()) {
            Requirements::add_i18n_javascript('silverstripe/cms: client/lang', false);

            $topLink = $page->Link();
            // special case home
            if (strstr($topLink, '?', true) == '/' || $topLink === '/') {
                $defaultHomepage = RootURLController::config()->get('default_homepage_link');
                $topLink = '/' . $defaultHomepage;
            }

            $fields->insertAfter(
                'Title',
                SiteTreeURLSegmentField::create('URLSegment')
                    ->setURLPrefix($topLink . '/')
                    ->setURLSuffix('?stage=Live')
                    ->setDefaultURL($this->getOwner()->generateURLSegment()),
            );
        } else {
            $message = _t(
                __CLASS__ . '.NoSlugHolderPage',
                'No SlugHolderPage found for this model. Create one in the page tree and select this model type.',
            );
            $fields->replaceField('URLSegment', LiteralField::create(
                'NoParent',
                '<p class="alert alert-warning">' . $message . '</p>',
            ));
        }
    }

    public function DefaultMetaTitle()
    {
        if (!$this->getOwner()->MetaTitle) {

            // if this lives in the model, Title won't be there in time, since "Title" lives in this extension

            $dmt = $this->getOwner()->Title;

            if ($this->getOwner()->ClassName == 'Kraftausdruck\Models\PodcastEpisode') {
                $dmt .= ' - ' . $this->getOwner()->Subtitle;
            }

            if ($this->getOwner()->ClassName == 'Kraftausdruck\Models\JobPosting') {
                $locations = $this->getOwner()->JobLocations()->Column('Town');
                $locations = implode(', ', $locations);
                $dmt .= ', ' . $locations;
            }

            if ($this->getOwner()->ClassName == Perso::class) {
                return $this->getOwner()->Firstname . ' ' . $this->getOwner()->Lastname . ' - ' . $this->getOwner()->Position;
            }

            return $dmt;
        }
    }

    public function DefaultMetaDescription()
    {
        $dmd = '';
        if ($this->getOwner()->MetaDescription) {
            $dmd = $this->getOwner()->MetaDescription;
        } elseif ($page = $this->getOwner()->Parent()) {
            $dmd = $page->MetaDescription;
        }

        return $dmd;
    }

    // Returns the SlugHolderPage managing this model type
    public function Parent(): ?SlugHolderPage
    {
        $class = get_class($this->getOwner());
        if (!array_key_exists($class, self::$slugHolderCache)) {
            self::$slugHolderCache[$class] = SlugHolderPage::get()->filter('ManagedModel', $class)->first();
        }

        return self::$slugHolderCache[$class];
    }

    public function generateURLSegment()
    {
        $anchor = $this->getOwner()->URLSegment;

        if ($anchor == '') {
            $filter = new URLSegmentFilter();
            $anchor = $filter->filter($this->getOwner()->Title);
        }

        if ($this->getOwner()->ID && $this->getOwner()->ClassName::get()->filter(['URLSegment' => $this->getOwner()->URLSegment])->exclude('ID', $this->getOwner()->ID)->count() > 0) {
            $anchor .= '-' . $this->getOwner()->ID;
        }

        return $anchor;
    }

    public function Link($action = null)
    {
        if (!$this->getOwner()->isInDB()) {
            return null;
        }
        $holder = $this->getOwner()->Parent();
        if ($holder) {
            return Controller::join_links(
                $holder->Link(),
                $this->getOwner()->URLSegment,
                $action,
            );
        }

        return null;
    }

    public function AbsoluteLink($action = null)
    {
        if ($this->Link()) {
            return Director::absoluteURL($this->Link($action));
        }

        return null;
    }

    public function BreadcrumbListSchema(): string
    {
        $pageObjs = [];
        $i = 1;

        $page = Controller::curr()->data();
        if ($page && $page->hasMethod('getBreadcrumbItems')) {
            foreach ($page->getBreadcrumbItems() as $item) {
                $pageObjs[] = Schema::ListItem()
                    ->position($i++)
                    ->name($item->Title)
                    ->item(
                        Schema::Thing()->setProperty('@id', $item->AbsoluteLink()),
                    );
            }
        }

        if ($this->getOwner()->Link()) {
            $pageObjs[] = Schema::ListItem()
                ->position($i)
                ->name($this->getOwner()->Title)
                ->item(
                    Schema::Thing()->setProperty('@id', $this->getOwner()->AbsoluteLink()),
                );
        }

        return Schema::BreadcrumbList()
            ->itemListElement($pageObjs)
            ->toScript();
    }

    public function Breadcrumbs($maxDepth = 20, $unlinked = false, $stopAtPageType = false, $showHidden = false)
    {
        $page = Controller::curr();
        $pages = [];
        $pages[] = $this->getOwner();
        while ($page
            && (!$maxDepth || count($pages) < $maxDepth)
            && (!$stopAtPageType || $page->ClassName != $stopAtPageType)
        ) {
            if ($showHidden || $page->ShowInMenus || ($page->ID == $this->getOwner()->ID)) {
                $pages[] = $page;
            }
            $page = $page->Parent;
        }
        $template = new SSViewer('BreadcrumbsTemplate');

        return $template->process($this->getOwner()->customise(ArrayData::create([
            'Pages' => new ArrayList(array_reverse($pages)),
        ])));
    }

    public function onAfterWrite()
    {
        if (!$this->getOwner()->URLSegment) {
            $this->getOwner()->URLSegment = $this->getOwner()->Title;
            $this->getOwner()->write();
        }
        if ($this->getOwner()->ClassName::get()
            ->filter(['URLSegment' => $this->getOwner()->URLSegment])
            ->exclude(['ID' => $this->getOwner()->ID])
            ->count()) {
            $this->getOwner()->URLSegment .= '-' . $this->getOwner()->ID;
            $this->getOwner()->write();
        }
    }

    // sitemap.xml
    // todo: come-up with something more sensible
    public function getGooglePriority()
    {
        return 1;
    }

    public function getMenuTitle()
    {
        if (property_exists($this->getOwner(), 'MenuTitle') && strlen($this->getOwner()->MenuTitle)) {
            return $this->getOwner()->MenuTitle;
        }

        return $this->getOwner()->Title;
    }
}
