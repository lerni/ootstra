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

    private bool $collisionResolved = false;

    private ?bool $active = null;

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

        $labels['Title'] = _t(self::class . '.TITLE', 'Title');
        $labels['MetaTitle'] = _t(self::class . '.METATITLE', 'Meta Title');
        $labels['MetaDescription'] = _t(self::class . '.METADESCRIPTION', 'Meta Description');

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
            _t(self::class.'.MetadataToggle', 'Metadata'),
            [
                $MetaTitleField = TextField::create('MetaTitle'),
                $MetaDescriptionField = TextareaField::create('MetaDescription'),
            ],
        )->setHeadingLevel(4);

        $MetaTitleField->setTargetLength(60, 50, 60);
        $MetaTitleField->setAttribute('placeholder', $this->getOwner()->DefaultMetaTitle());
        $MetaTitleField->setRightTitle(_t('\Page.MetaTitleRightTitle', 'Used as a title in the browser and for search engine results. Important for SEO!'));

        $MetaDescriptionField->setTargetLength(160, 100, 160);
        $MetaDescriptionField->setAttribute('placeholder', $this->getOwner()->DefaultMetaDescription());
        $MetaDescriptionField->setRightTitle(_t('\Page.MetaDescriptionRightTitle', 'Used in search engine results when length fits and relevance is given; hardly affects SEO position. Appealing meta-descriptions (especially the first ~ 55 characters -> sitelinks) have a strong influence on the click rate.'));

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
                self::class . '.NoSlugHolderPage',
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
        if ($this->getOwner()->MetaTitle) {
            return $this->getOwner()->MetaTitle;
        }

        $owner = $this->getOwner();

        if ($owner->ClassName == 'Kraftausdruck\Models\PodcastEpisode') {
            return implode(' - ', array_filter([$owner->Title, $owner->Subtitle]));
        }

        if ($owner->ClassName == 'Kraftausdruck\Models\JobPosting') {
            $locations = implode(', ', $owner->JobLocations()->Column('Town'));

            return implode(', ', array_filter([$owner->Title, $locations]));
        }

        if ($owner->ClassName == Perso::class) {
            $name = implode(' ', array_filter([$owner->Firstname, $owner->Lastname]));

            return implode(' - ', array_filter([$name, $owner->Position]));
        }

        return $owner->Title;
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
        $class = $this->getOwner()::class;
        if (!array_key_exists($class, self::$slugHolderCache)) {
            self::$slugHolderCache[$class] = SlugHolderPage::get()->filter(['ManagedModel' => $class])->first();
        }

        return self::$slugHolderCache[$class];
    }

    public function generateURLSegment()
    {
        $anchor = $this->getOwner()->URLSegment;

        if ($anchor == '') {
            $filter = URLSegmentFilter::create();
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
        $template = SSViewer::create('BreadcrumbsTemplate');

        return $template->process($this->getOwner()->customise(ArrayData::create([
            'Pages' => ArrayList::create(array_reverse($pages)),
        ])));
    }

    public function onBeforeWrite()
    {
        $owner = $this->getOwner();
        $filter = URLSegmentFilter::create();

        // Generate slug from Title if empty or still default
        if (!$owner->URLSegment || $owner->URLSegment === 'new-item') {
            $owner->URLSegment = $filter->filter($owner->Title);
        } elseif ($owner->isChanged('URLSegment')) {
            $owner->URLSegment = $filter->filter($owner->URLSegment);
        }

        // Resolve collisions for existing records (we have the ID)
        if ($owner->ID) {
            if ($owner->ClassName::get()
                ->filter(['URLSegment' => $owner->URLSegment])
                ->exclude(['ID' => $owner->ID])
                ->exists()) {
                $owner->URLSegment .= '-' . $owner->ID;
            }
            $this->collisionResolved = true;
        }
    }

    public function onAfterWrite()
    {
        // Existing records already handled in onBeforeWrite
        if ($this->collisionResolved) {
            $this->collisionResolved = false;

            return;
        }

        // New records: now we have an ID, check for collisions
        $owner = $this->getOwner();
        if ($owner->ClassName::get()
            ->filter(['URLSegment' => $owner->URLSegment])
            ->exclude(['ID' => $owner->ID])
            ->exists()) {
            $owner->URLSegment .= '-' . $owner->ID;
            $owner->write();
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

    public function setSlugActive(?bool $active): void
    {
        $this->active = $active;
    }

    public function isCurrent(): bool
    {
        return $this->active === true;
    }

    public function isSection(): bool
    {
        return $this->isCurrent() || $this->active === false;
    }

    public function LinkOrCurrent(): string
    {
        return $this->isCurrent() ? 'current' : 'link';
    }

    public function LinkOrSection(): string
    {
        return $this->isSection() ? 'section' : 'link';
    }

    public function LinkingMode(): string
    {
        if ($this->isCurrent()) {
            return 'current';
        }

        if ($this->isSection()) {
            return 'section';
        }

        return 'link';
    }
}
