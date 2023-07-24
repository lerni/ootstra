<?php

namespace App\Elements;

use App\Models\ElementPage;
use SilverStripe\TagField\TagField;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Control\Controller;
use SilverStripe\Core\Config\Config;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Blog\Model\BlogPost;
use SilverStripe\Blog\Model\BlogCategory;
use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\View\Parsers\URLSegmentFilter;
use SilverStripe\Versioned\GridFieldArchiveAction;
use SilverStripe\Forms\GridField\GridFieldPageCount;
use SilverStripe\Forms\GridField\GridFieldEditButton;
use SilverStripe\Forms\GridField\GridFieldAddNewButton;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use SilverStripe\Forms\GridField\GridFieldFilterHeader;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use SilverStripe\Blog\Admin\GridFieldCategorisationConfig;
use SilverStripe\Forms\GridField\GridFieldConfig_RelationEditor;
use SilverStripe\Forms\GridField\GridFieldAddExistingAutocompleter;


class ElementFeedTeaser extends BaseElement
{
    private static $db = [
        'Layout' => 'Enum("third,halve,full", "third")',
        'FirstLinkAction' => 'Varchar',
        'CountMax' => 'Int'
    ];

    private static $has_one = [];

    private static $has_many = [];

    private static $many_many = [
        'FeedTeaserParents' => SiteTree::class,
        'Categories' => BlogCategory::class
    ];

    private static $many_many_extraFields = [
        'Categories' => [
            'MMSortOrder' => 'Int'
        ]
    ];

    private static $defaults = [
        'CountMax' => 3
    ];

    private static $table_name = 'ElementFeedTeaser';

    private static $title = 'Feed Teaser Element';

    private static $icon = 'font-icon-block-layout-2';

    public function fieldLabels($includerelations = true)
    {
        $labels = parent::fieldLabels($includerelations);
        $labels['CountMax'] = _t(__CLASS__ . '.COUNTMAX', 'Number of teasers (default 3)');
        $labels['FirstLinkAction'] = _t(__CLASS__ . '.FIRSTLINKACTION', 'Text link parent (first)');
        return $labels;
    }

    function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->removeByName([
            'FeedTeaserParents',
            'Categories',
            'WidthReduced'
        ]);

        $fields->addFieldToTab('Root.Main', LiteralField::create('How', '
            <h2>'. _t(__CLASS__ . '.HowTitle', 'What is shown?') .'</h2>
            <p>'. _t(__CLASS__ . '.HowText', 'Subpages (children) of the selected pages (parents / holders) e.g. news with the selected categories are teased. Image & text can be selected on the respective pages in the tab "Feeds & Share".') .'<br/><br/></p>
        '));

        // hack around unsaved relations
        if ($this->isInDB()) {
            $TeaserGridFieldConfig = GridFieldConfig_RelationEditor::create();
            $TeaserGridFieldConfig->removeComponentsByType([
                GridFieldPageCount::class,
                GridFieldArchiveAction::class,
                GridFieldEditButton::class,
                GridFieldAddNewButton::class,
                GridFieldFilterHeader::class
            ]);
            $gridField = new GridField('FeedTeaserParents', _t(__CLASS__ . '.FEEDTEASERPARENTS', 'Parents / Holders of Linked Pages'), $this->FeedTeaserParents(), $TeaserGridFieldConfig);
            $fields->addFieldToTab('Root.Main', $gridField);
        } else {
            $fields->addFieldToTab('Root.Main', LiteralField::create('firstsave', '<p style="font-weight:bold; color:#555;">' . _t('SilverStripe\CMS\Controllers\CMSMain.SaveFirst', 'none') . '</p>'));
        }

        $CatGFConfig = GridFieldCategorisationConfig::create(
            15,
            $this->Categories()->sort('MMSortOrder'),
            BlogCategory::class,
            'Categories',
            'BlogPosts'
        );

        $CatGFConfig->addComponents([
            new GridFieldAddExistingAutocompleter('toolbar-header-right'),
            new GridFieldDeleteAction(true)
        ]);

        // hack around unsaved relations
        if ($this->isInDB()) {
            $CatGFConfig->addComponent(new GridFieldOrderableRows('MMSortOrder'));
        }

        $categories = GridField::create(
            'Categories',
            _t('SilverStripe\Blog\Model\BlogPost.Categories', 'Categories'),
            $this->Categories(),
            $CatGFConfig
        );

        $fields->addFieldToTab('Root.' . _t('SilverStripe\Blog\Model\BlogPost.Categories', 'Categories'), $categories);

        return $fields;
    }

    public function Items()
    {
        if ($this->FeedTeaserParents()->count()) {
            $parentIDs = (array)$this->FeedTeaserParents()->Column('ID');

            $blogSorting = Config::inst()->get(BlogPost::class, 'default_sort');

            if (count($parentIDs) == 1 &&
                $this->FeedTeaserParents()->first()->ClassName == 'SilverStripe\Blog\Model\Blog') {
                    $childrens = BlogPost::get()->filter('ParentID', $parentIDs);
                    // If Blog is sorted per date?
                    if (substr($blogSorting, 0, strlen('PublishDate DESC')) === 'PublishDate DESC') {
                        $childrens = $childrens->sort('PublishDate DESC');
                    }
            } else {
                $childrens = ElementPage::get()->filter('ParentID', $parentIDs);
            }

            if ($filter = $this->getURLCategoryFilter()) {
                $childrens = $childrens->filterAny('Categories.URLSegment', $filter);
            }

            if ($this->CountMax && $childrens->count()) {
                $childrens = $childrens->limit($this->CountMax);
            }

            // fill up to CountMax if less than
            if ($childrens->count() < $this->CountMax) {
                $exclude = $childrens->Column('ID');
                $padfill = $this->CountMax - $childrens->count();

                $additionalPosts = SiteTree::get()->filter('ParentID', $parentIDs);

                // just exclude if there is something to
                if (count($exclude)) {
                    $additionalPosts = $additionalPosts->exclude('ID', $exclude);
                }

                $additionalPosts = $additionalPosts->limit($padfill);

                foreach ($additionalPosts as $addItem) {
                    $childrens->add($addItem);
                }
            }

            return $childrens;
        }
    }

    public function getURLCategoryFilter()
    {
        $getVars = Controller::curr()->getRequest()->getVars();
        if (isset($getVars['tags'])) {

            $tags = explode(',', $getVars['tags']);
            $tagsURLEnc = [];
            foreach ($tags as $tag) {
                $filter = new URLSegmentFilter();
                //				$filter->setAllowMultibyte(true);
                array_push($tagsURLEnc, $filter->filter($tag));
            }

            $allTags = $this->Categories()->Column('Title');
            $AllTagsURLEnc = [];
            foreach ($allTags as $key => $tag) {
                $filter = new URLSegmentFilter();
                //				$filter->setAllowMultibyte(true);
                $AllTagsURLEnc[$key] = $filter->filter($tag);
            }

            $tagsValid = [];
            foreach ($tagsURLEnc as $item) {
                if (in_array($item, $AllTagsURLEnc))
                    $tagsValid[array_search($item, $AllTagsURLEnc)] = $item;
            }

            return $tagsValid;
        }
    }

    // protected function provideBlockSchema()
    // {
    // 	$blockSchema = parent::provideBlockSchema();
    // 	if ($this->Items()->count() && $this->Items()->first()->OGImage()->exists()) {
    // 		$blockSchema['fileURL'] = $this->Items()->first()->OGImage()->CMSThumbnail()->getURL();
    // 	}
    // 	return $blockSchema;
    // }

    public function getType()
    {
        return _t(__CLASS__ . '.BlockType', 'Teaser (feed)');
    }
}
