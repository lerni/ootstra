<?php

namespace App\Elements;

use SilverStripe\TagField\TagField;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Control\Controller;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Blog\Model\BlogCategory;
use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Versioned\GridFieldArchiveAction;
use SilverStripe\Forms\GridField\GridFieldPageCount;
use SilverStripe\Forms\GridField\GridFieldEditButton;
use SilverStripe\Forms\GridField\GridFieldAddNewButton;
use SilverStripe\Forms\GridField\GridFieldConfig_RelationEditor;
use SilverStripe\Forms\GridField\GridFieldFilterHeader;
use SilverStripe\View\Parsers\URLSegmentFilter;


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
            'SortOrder' => 'Int'
        ]
    ];

    private static $defaults = [
        'CountMax' => 3
    ];

    private static $table_name = 'ElementFeedTeaser';

    private static $title = 'Feed Teaser Element';

    private static $icon = 'font-icon-block-layout-2';

    private static $inline_editable = false;

    public function fieldLabels($includerelations = true)
    {
        $labels = parent::fieldLabels($includerelations);
        $labels['CountMax'] = _t(__CLASS__ . '.COUNTMAX', 'Anzahl Teasers (default 3)');
        $labels['FirstLinkAction'] = _t(__CLASS__ . '.FIRSTLINKACTION', 'Text link parent (first)');
        return $labels;
    }

    function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->removeByName('FeedTeaserParents');
        $fields->removeByName('Categories');

        $fields->addFieldToTab('Root.Main', LiteralField::create('How', '
            <h2>'. _t(__CLASS__ . '.HowTitle', 'Höhe nicht begrenzen') .'</h2>
            <p>'. _t(__CLASS__ . '.HowText', 'Es werden Unterseiten (Kinder) der gewählten Seiten (Eltern/Holders) z.B. News mit den gewählten Kategorien angeteasert. Bild & Text kann auf jeweiligen Seiten im Tab "Feeds & Share" gewählt werden.') .'<br/><br/></p>
        '));

        // hack arround unsaved relations
        if ($this->isInDB()) {
            $TeaserGridFieldConfig = GridFieldConfig_RelationEditor::create();
            $TeaserGridFieldConfig->removeComponentsByType([
                GridFieldPageCount::class,
                GridFieldArchiveAction::class,
                GridFieldEditButton::class,
                GridFieldAddNewButton::class,
                GridFieldFilterHeader::class
            ]);
            $gridField = new GridField('FeedTeaserParents', _t(__CLASS__ . '.FEEDTEASERPARENTS', 'Eltern/Holders verlinkter Seiten'), $this->FeedTeaserParents(), $TeaserGridFieldConfig);
            $fields->addFieldToTab('Root.Main', $gridField);
        } else {
            $fields->addFieldToTab('Root.Main', LiteralField::create('firstsave', '<p style="font-weight:bold; color:#555;">' . _t('SilverStripe\CMS\Controllers\CMSMain.SaveFirst', 'none') . '</p>'));
        }

        $CategoriyField = TagField::create(
            'Categories',
            _t('SilverStripe\Blog\Model\Blog.Categories', 'Categories'),
            BlogCategory::get(), //
            $this->Categories()
        );

        $fields->addFieldToTab('Root.Main', $CategoriyField);

        return $fields;
    }

    public function Items()
    {
        if ($this->FeedTeaserParents()->count()) {
            $parentIDs = (array)$this->FeedTeaserParents()->Column('ID');

            $childrens = SiteTree::get()->filter('ParentID', $parentIDs)->Sort('Sort ASC');
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

                $additionalPosts = SiteTree::get()->filter('ParentID', $parentIDs)->Sort('Sort ASC');

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
