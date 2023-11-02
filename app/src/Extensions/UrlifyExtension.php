<?php

namespace App\Extensions;

use App\Models\ElementPage;
use SilverStripe\ORM\ArrayList;
use SilverStripe\View\SSViewer;
use SilverStripe\Core\Extension;
use SilverStripe\View\ArrayData;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\Control\Director;
use SilverStripe\View\Requirements;
use SilverStripe\Control\Controller;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\TextareaField;
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

    public function populateDefaults()
    {
        $this->owner->Title = _t(__CLASS__ . '.DefaultTitle', 'New item');
        // todo DatePosted is not for all
        $this->owner->DatePosted = date('Y-m-d');
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
        $MetaTitleField->setAttribute('placeholder', $this->owner->DefaultMetaTitle());
        $MetaTitleField->setRightTitle(_t('\Page.MetaTitleRightTitle', 'Wird als Titel im Browsertab und für Suchmaschinen Resultate verwendet. Wichtig für SEO!'));

        $MetaDescriptionField->setTargetLength(160, 100, 160);
        $MetaDescriptionField->setAttribute('placeholder', $this->owner->DefaultMetaDescription());
        $MetaDescriptionField->setRightTitle(_t('\Page.MetaDescriptionRightTitle', 'Wird in Suchmaschinen-Ergebnissen verwendet, wenn Länge passt und Relevanz gegeben ist; beeinflusst die SEO-Position kaum. Ansprechende Meta-Descripton (besonders die ersten ~55 Zeichen -> Sitelinks) beeinflussen die Klickrate jedoch stark.'));

        $fields->insertAfter(
            'Title',
            $MetaToggle,
        );

        if ($page = $this->owner->Parent()) {
            Requirements::add_i18n_javascript('silverstripe/cms: client/lang', false, true);
            if ($this->owner->config()->parent_slug) {
                $parentSlug = $this->owner->config()->parent_slug;
            } else {
                $parentSlug = 'item';
            }

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
                    ->setDefaultURL($this->owner->generateURLSegment())

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
        if (!$this->owner->MetaTitle) {

            // if this lives in the model, Title won't be there in time, since "Title" lives in this extension

            $dmt = $this->owner->Title;

            if ($this->owner->ClassName == 'Kraftausdruck\Models\PodcastEpisode') {
                $dmt .= ' - ' . $this->owner->Subtitle;
            }

            if ($this->owner->ClassName == 'Kraftausdruck\Models\JobPosting') {
                $locations = [];
                $locations = $this->owner->JobLocations()->Column('Town');
                $locations = implode(', ', $locations);
                $dmt .= ', ' . $locations;
            }

            if ($this->owner->ClassName == 'App\Models\Perso') {
                $dmt = $this->owner->Firstname . ' ' . $this->owner->Lastname . ' - ' . $this->owner->Position;
            }

            return $dmt;
        }
    }

    public function DefaultMetaDescription()
    {
        $dmd = '';
        if ($this->owner->MetaDescription) {
            $dmd = $this->owner->MetaDescription;
        } elseif ($this->owner->Parent() && $this->owner->Parent()->getPage()) {
            $page = $this->owner->Parent()->getPage();
            $dmd = $page->MetaDescription;
        }
        return $dmd;
    }

    // returns the Element of the DO
    public function Parent()
    {
        $parentClass = $this->owner->config()->parent_class;
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
        $anchor = $this->owner->URLSegment;

        if ($anchor == '') {
            $filter = new URLSegmentFilter();
            $anchor = $filter->filter($this->owner->Title);
        }

        if ($this->owner->ID && $this->owner->ClassName::get()->filter(['URLSegment' => $this->owner->URLSegment])->exclude('ID', $this->owner->ID)->count() > 0) {
            $anchor .= '-' . $this->owner->ID;
        }
        return $anchor;
    }

    public function Link($action = null)
    {
        $parentSlug = $this->owner->config()->parent_slug;
        $c = Controller::curr();
        // $action = $c->urlParams['Action'];
        if ($this->owner->Parent() && $this->owner->isInDB()) {
        // if ($this->owner->Parent() && $this->owner->isInDB() && $parentSlug == $action) {
            $areaID = $this->owner->Parent()->ParentID;
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
                    $this->owner->URLSegment,
                    $action
                );
            }
        }
    }

    public function AbsoluteLink($action = null)
    {
        return Director::absoluteURL($this->Link($action));
    }

    public function Breadcrumbs($maxDepth = 20, $unlinked = false, $stopAtPageType = false, $showHidden = false)
    {
        $page = Controller::curr();
        $pages = [];
        $pages[] = $this->owner;
        while ($page
            && (!$maxDepth || count($pages) < $maxDepth)
            && (!$stopAtPageType || $page->ClassName != $stopAtPageType)
        ) {
            if ($showHidden || $page->ShowInMenus || ($page->ID == $this->owner->ID)) {
                $pages[] = $page;
            }
            $page = $page->Parent;
        }
        $template = new SSViewer('BreadcrumbsTemplate');

        return $template->process($this->owner->customise(new ArrayData([
            'Pages' => new ArrayList(array_reverse($pages)),
        ])));
    }

    public function onAfterWrite()
    {
        if (!$this->owner->URLSegment) {
            $this->owner->URLSegment = $this->owner->Title;
            $this->owner->write();
        }
        if ($this->owner->ClassName::get()
            ->filter(['URLSegment' => $this->owner->URLSegment])
            ->exclude(['ID' => $this->owner->ID])
            ->count())
        {
            $this->owner->URLSegment .= '-' . $this->owner->ID;
            $this->owner->write();
        }
    }

    // sitemap.xml
    // todo: come-up with something more sensible
    public function getGooglePriority()
    {
        return 1;
    }

    public function getMenuTitle() {
        if (property_exists($this->owner, 'MenuTitle') && strlen($this->owner->MenuTitle)) {
            $r = $this->owner->MenuTitle;
        } else {
            $r = $this->owner->Title;
        }
        return $r;
    }
}
