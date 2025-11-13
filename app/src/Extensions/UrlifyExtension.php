<?php

namespace App\Extensions;

use App\Models\Perso;
use App\Models\ElementPage;
use SilverStripe\View\SSViewer;
use SilverStripe\Core\Extension;
use SilverStripe\Model\ArrayData;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
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

// WIP unify URLs on DataObject with Elemental
// ATM we work with "Primary" Element but...
// this functionality will likely change and 'll also be refactored into an extension

class UrlifyExtension extends Extension
{

    private static $db = [
        'Sort' => 'Int',
        'Title' => 'Varchar',
        'URLSegment' => 'Varchar',
        'MetaTitle' => 'Varchar',
        'MetaDescription' => 'Text'
    ];

    private static $indexes = [
        'URLSegment' => true
    ];

    private static $defaults = [
        'URLSegment' => 'new-item'
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
            'MetaDescription'
        ]);

        $MetaToggle = ToggleCompositeField::create(
            'Metadata',
            _t(__CLASS__.'.MetadataToggle', 'Metadata'),
            [
                $MetaTitleField = new TextField('MetaTitle'),
                $MetaDescriptionField = new TextareaField('MetaDescription')
            ]
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
            $parentSlug = $this->getOwner()->config()->parent_slug ?: 'item';

            // special case home
            $base = Director::absoluteBaseURL();
            $PageLink = $this->Parent()->getPage()->Link();
            // special case home
            if (strstr($PageLink, '?', true) == '/' || $PageLink === '/') {
                $defaultHomepage = RootURLController::config()->get('default_homepage_link');
                $PageLink = '/' . $defaultHomepage;
            }
            $topLink = Controller::join_links(
                $PageLink,
                $parentSlug
            );

            $fields->insertAfter(
                'Title',
                SiteTreeURLSegmentField::create('URLSegment')
                    ->setURLPrefix($topLink . '/')
                    ->setURLSuffix('?stage=Live')
                    ->setDefaultURL($this->getOwner()->generateURLSegment())

            );
        } else {
            $uiElement = _t('Kraftausdruck\Elements\ElementPodcast.BlockType', 'Podcast Element');
            $message = _t(__CLASS__ . '.NoParentElement', 'A parent element is currently missing! Insert a {element} in the page tree and then assign a URL here.', [ 'element' => $uiElement ]);
            $fields->replaceField('URLSegment', LiteralField::create(
                'NoParent', '<p class="alert alert-warning">'. $message .'</p>'
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
        } elseif ($this->getOwner()->Parent() && $this->getOwner()->Parent()->getPage()) {
            $page = $this->getOwner()->Parent()->getPage();
            $dmd = $page->MetaDescription;
        }
        return $dmd;
    }

    // returns the Element of the DO
    public function Parent()
    {
        $parentClass = $this->getOwner()->config()->parent_class;
        if($parentClass::get()->count()) {
            $e = $parentClass::get()->filter(['Primary' => 1])->first();
            if (!$e) {
                $e = $parentClass::get()->first();
            }
            return $e;
        }
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
        $parentSlug = $this->getOwner()->config()->parent_slug;
        Controller::curr();
        // $action = $c->urlParams['Action'];
        if ($this->getOwner()->Parent() && $this->getOwner()->isInDB()) {
        // if ($this->owner->Parent() && $this->owner->isInDB() && $parentSlug == $action) {
            $areaID = $this->getOwner()->Parent()->ParentID;
            $Page = ElementPage::get()->filter(['ElementalAreaID' => $areaID])->first();
            if ($Page) {
                $siteURL = $Page->Link();
                // special case home
                if (strstr($siteURL, '?', true) == '/' || $siteURL === '/') {
                    $defaultHomepage = RootURLController::config()->get('default_homepage_link');
                    $siteURL = '/' . $defaultHomepage;
                }
                return Controller::join_links(
                    $siteURL,
                    $parentSlug,
                    $this->getOwner()->URLSegment,
                    $action
                );
            }
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
            'Pages' => new ArrayList(array_reverse($pages))
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
            ->count())
        {
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

    public function getMenuTitle() {
        if (property_exists($this->getOwner(), 'MenuTitle') && strlen($this->getOwner()->MenuTitle)) {
            return $this->getOwner()->MenuTitle;
        }
        return $this->getOwner()->Title;
    }
}
