<?php

namespace App\Elements;

use App\Models\ElementPage;
use SilverStripe\i18n\i18n;
use SilverStripe\Blog\Model\Blog;
use Psr\SimpleCache\CacheInterface;
use SilverStripe\TagField\TagField;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Control\Controller;
use SilverStripe\Core\Config\Config;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Blog\Model\BlogPost;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\Blog\Model\BlogCategory;
use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\View\Parsers\URLSegmentFilter;
use SilverStripe\Versioned\GridFieldArchiveAction;
use SilverStripe\Forms\GridField\GridFieldPageCount;
use SilverStripe\Forms\GridField\GridFieldEditButton;
use SilverStripe\Forms\GridField\GridFieldAddNewButton;
use SilverStripe\Forms\GridField\GridFieldFilterHeader;
use SilverStripe\Forms\GridField\GridFieldConfig_RelationEditor;

class ElementFeedTeaser extends BaseElement
{
    private static $db = [
        'Layout' => 'Enum("third,halve,full", "third")',
        'ShowAsSlider' => 'Boolean',
        'FirstLinkAction' => 'Varchar',
        'CountMax' => 'Int',
        'Shuffle' => 'Boolean'
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
        $labels['ShowAsSlider'] = _t(__CLASS__ . '.SHOWASSLIDER', 'Show as slider');
        $labels['FirstLinkAction'] = _t(__CLASS__ . '.FIRSTLINKACTION', 'Text link parent (first)');
        $labels['Shuffle'] = _t(__CLASS__ . '.SHUFFLE', 'randomize sort order');
        return $labels;
    }

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->removeByName([
            'FeedTeaserParents',
            'Categories'
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
                GridFieldFilterHeader::class,
                GridFieldFilterHeader::class
            ]);
            $gridField = new GridField('FeedTeaserParents', _t(__CLASS__ . '.FEEDTEASERPARENTS', 'Parents / Holders of Linked Pages'), $this->FeedTeaserParents(), $TeaserGridFieldConfig);
            $fields->addFieldToTab('Root.Main', $gridField);
        } else {
            $fields->addFieldToTab('Root.Main', LiteralField::create('firstsave', '<p style="font-weight:bold; color:#555;">' . _t('SilverStripe\CMS\Controllers\CMSMain.SaveFirst', 'none') . '</p>'));
        }

        $CategoryField = TagField::create(
            'Categories',
            _t('SilverStripe\Blog\Model\Blog.Categories', 'Categories'),
            BlogCategory::get(),
            $this->Categories()
        );

        $fields->addFieldToTab('Root.Main', $CategoryField);

        return $fields;
    }

    public function Items()
    {
        $childrenMaxLastEdited = SiteTree::get()->max('LastEdited');
        $childrenCount = SiteTree::get()->count();
        $categoriesIds = serialize($this->Categories()->column('ID'));
        $parentsIds = serialize($this->FeedTeaserParents()->column('ID'));
        $rotatingCacheKey = $this->RotatingCacheKey();
        $currentLocale = i18n::get_locale();

        $cacheKey = md5($this->LastEdited . $childrenMaxLastEdited . $childrenCount . $categoriesIds . $parentsIds . $rotatingCacheKey . $currentLocale);

        $cache = Injector::inst()->get(CacheInterface::class . '.ElementFeedTeaser');

        if ($cache->has($cacheKey)) {
            return unserialize($cache->get($cacheKey));
        }

        $result = null;

        if ($this->FeedTeaserParents()->count()) {
            $parentIDs = (array)$this->FeedTeaserParents()->Column('ID');

            $categoryFilter = [];
            if ($this->Categories()->Count()) {
                $categoryFilter = $this->Categories()->Column('ID');
            }

            $blogSorting = Config::inst()->get(BlogPost::class, 'default_sort');

            if (count($parentIDs) === 1 &&
                $this->FeedTeaserParents()->first()->ClassName == Blog::class) {

                $childrens = BlogPost::get()
                    ->filter('ParentID', $parentIDs)
                    ->eagerLoad('Categories');

                // If Blog is sorted per date?
                if (str_starts_with($blogSorting, 'PublishDate DESC')) {
                    $childrens = $childrens->sort('PublishDate DESC');
                }
            } else {
                $childrens = ElementPage::get()
                    ->filter('ParentID', $parentIDs)
                    ->eagerLoad('PageCategories');
            }

            if (!empty($categoryFilter)) {
                if ($this->FeedTeaserParents()->first()->ClassName == Blog::class) {
                    $childrens = $childrens->filter('Categories.ID', $categoryFilter);
                } else {
                    $childrens = $childrens->filter('PageCategories.ID', $categoryFilter);
                }
            }

            if ($this->CountMax && $childrens->count()) {
                $childrens = $childrens->limit($this->CountMax);
            }

            // fill up to CountMax if less than
            if ($childrens->count() < $this->CountMax) {
                $exclude = $childrens->Column('ID');
                $padfill = $this->CountMax - $childrens->count();

                $additionalPosts = SiteTree::get()
                    ->filter('ParentID', $parentIDs)
                    ->limit($padfill);

                // just exclude if there is something to
                if (count($exclude)) {
                    $additionalPosts = $additionalPosts->exclude('ID', $exclude);
                }

                foreach ($additionalPosts as $addItem) {
                    $childrens->add($addItem);
                }
            }

            $result = $childrens;
        }

        if ($result) {
            if ($this->Shuffle) {
                $result = $result->Shuffle();
            }
            $cache->set($cacheKey, serialize($result), 3600);
        }

        return $result;
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
                $tagsURLEnc[] = $filter->filter($tag);
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
                if (in_array($item, $AllTagsURLEnc)) {
                    $tagsValid[array_search($item, $AllTagsURLEnc, true)] = $item;
                }
            }

            return $tagsValid;
        }
        return null;
    }

    public function ChildTitleLevel()
    {
        $l = (int)$this->TitleLevel;
        ++$l;
        return 'h' . $l;
    }

    public function FeedTeaserParentsWithCategory(): ?string
    {
        $parents = $this->FeedTeaserParents();
        if (!$parents->count()) {
            return null;
        }

        $parent = $parents->first();
        $parsedUrl = parse_url($parent->AbsoluteLink());
        $link = "{$parsedUrl['scheme']}://{$parsedUrl['host']}{$parsedUrl['path']}";

        $categories = $this->Categories();
        if (
            $parent->ClassName == Blog::class &&
            $categories->count() == 1
        ) {
            $category = $categories->first();
            $link .= "/category/{$category->URLSegment}";
        }

        return $link;
    }

    // timely rotating cache-key - workaround to shuffle cached items
    public function RotatingCacheKey() {
        if (!$this->Shuffle) {
            return 0;
        }
        $twentyMinutesBlock = floor(time() / 60 / 20); // twenty minutes TTL
        $key = 'key_' . ($twentyMinutesBlock % 2 == 0 ? 'even' : 'odd');
        $uniqueKey = crc32($key . $twentyMinutesBlock);
        return $uniqueKey;
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
