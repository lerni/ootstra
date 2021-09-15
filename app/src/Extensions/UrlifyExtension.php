<?php

namespace App\Extensions;

use App\Models\ElementPage;
use SilverStripe\Core\Extension;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\Control\Director;
use SilverStripe\View\Requirements;
use SilverStripe\Control\Controller;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\ToggleCompositeField;
use SilverStripe\View\Parsers\URLSegmentFilter;
use SilverStripe\CMS\Forms\SiteTreeURLSegmentField;


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

    private static $defaults = array(
        // todo: $what to use?
        'URLSegment' => 'new-podcast'
    );

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
        $this->owner->Title = _t(__CLASS__ . '.DefaultTitle', 'New podcast');
        $this->owner->DatePosted = date('Y-m-d');
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

    // todo: get it from getPage() of primary
    public function DefaultMetaDescription()
    {
        if ($this->owner->MetaDescription) {
            return $this->owner->MetaDescription;
        }
    }

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

        $MetaDescriptionField->setTargetLength(160, 100, 160);
        $MetaDescriptionField->setAttribute('placeholder', $this->owner->DefaultMetaDescription());

        $fields->insertAfter(
            $MetaToggle,
            'Title'
        );

        if ($page = $this->owner->Parent()) {
            Requirements::add_i18n_javascript('silverstripe/cms: client/lang', false, true);
            if ($this->owner->config()->parent_slug) {
                $parentSlug = $this->owner->config()->parent_slug;
            } else {
                $parentSlug = 'item';
            }
            $fields->insertAfter(
                SiteTreeURLSegmentField::create('URLSegment')
                    ->setURLPrefix($this->Parent()->getPage()->Link() . $parentSlug . '/')
                    ->setURLSuffix('?stage=Live')
                    ->setDefaultURL($this->owner->generateURLSegment()),
                'Title'
            );
        } else {
            $uiElement = _t('Kraftausdruck\Elements\ElementPodcast.BlockType', 'Podcast Element');
            $message = _t(__CLASS__ . '.NoParentElement', 'A parent element is currently missing! Insert a {element} in the page tree and then assign a URL here.', [ 'element' => $uiElement ]);
            $fields->replaceField('URLSegment', LiteralField::create(
                'NoParent', '<p class="alert alert-warning">'. $message .'</p>'
            ));
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

    // URL
    public function AbsoluteLink()
    {
        $parentSlug = $this->owner->config()->parent_slug;
        if ($this->owner->Parent() && $this->owner->isInDB()) {
            $base = Director::absoluteBaseURL();
            $areaID = $this->owner->Parent()->ParentID;
            $Page = ElementPage::get()->filter(['ElementalAreaID' => $areaID])->first();
            $siteURL = $Page->Link();
            // special case home
            if (strstr($siteURL, '?', true) == '/') {
                $siteURL = '/home';
            }
            return Controller::join_links(
                $base,
                $siteURL,
                $parentSlug,
                $this->owner->URLSegment
            );
        }
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
    // todo: come-up with something smarter
    public function getGooglePriority()
    {
        return 1;
    }
}
