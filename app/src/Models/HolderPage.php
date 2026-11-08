<?php

namespace App\Models;

use Page;
use App\Models\ElementPage;
use App\Utility\GridFieldHelper;
use SilverStripe\Admin\LeftAndMain;
use SilverStripe\Control\Controller;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Model\List\ArrayList;
use App\Controller\HolderPageController;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\View\Parsers\URLSegmentFilter;
use App\GridField\GridFieldConfig_SortableRelation;

class HolderPage extends Page
{
    private static $db = [
        'PreventHero' => 'Boolean',
    ];

    private static $has_one = [];

    private static $owns = [];

    private static $table_name = 'HolderPage';

    private static $allowed_children = [
        ElementPage::class,
    ];

    private static $defaults = [
        'HideSubNavi' => true,
        'PreventHero' => true,
    ];

    private static $controller_name = HolderPageController::class;

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->removeByName([
            'PageCategories',
        ]);

        $fields->addFieldToTab('Root.Main', CheckboxField::create('PreventHero', _t('App\Models\ElementPage.PREVENTHERO', 'Do not show default Hero-Slides')), 'Content');

        GridFieldHelper::addIfSaved($fields, $this, fn () => GridField::create('PageCategories', 'Kategorien', $this->PageCategories(), GridFieldConfig_SortableRelation::create('SortOrder')), 'Content');

        return $fields;
    }

    public function Items()
    {
        //$childrens =  $this->AllChildren();
        $childrens = ElementPage::get()->filter(['ParentID' => $this->ID]);
        if ($categoryFilter = $this->getURLCategoryFilter()) {
            $childrens = $childrens->filterAny(["PageCategories.URLSegment" => $categoryFilter]);
        }

        return $childrens;
    }

    public function CategoriesWithState()
    {
        $categories = $this->PageCategories();
        $currentCategories = [];
        if (!(Controller::curr() instanceof LeftAndMain)) {
            if (Controller::curr()->ClassName == HolderPage::class) {
                $currentCategories = $this->getURLCategoryFilter();
            } else {
                $currentCategories = Controller::curr()->PageCategories()->column('URLSegment');
            }
        }

        $r = ArrayList::create();

        foreach ($categories as $cat) {
            $filter = URLSegmentFilter::create();
            $filter->setAllowMultibyte(true);
            $TitleURLEnc = $filter->filter($cat->Title);
            $cat->CustomLinkingMode = $currentCategories && in_array($TitleURLEnc, $currentCategories) ? 'current' : 'link';
            $r->push($cat);
        }

        return $r;
    }

    public function getURLCategoryFilter()
    {
        $getVars = Controller::curr()->getRequest()->getVars();
        if (isset($getVars['tags'])) {

            $tags = explode(',', $getVars['tags']);
            $tagsURLEnc = [];
            foreach ($tags as $tag) {
                $filter = URLSegmentFilter::create();
                $filter->setAllowMultibyte(true);
                $tagsURLEnc[] = $filter->filter($tag);
            }

            $allTags = $this->PageCategories()->column('Title');
            $AllTagsURLEnc = [];
            foreach ($allTags as $key => $tag) {
                $filter = URLSegmentFilter::create();
                $filter->setAllowMultibyte(true);
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

    public function URLCategoryFirst()
    {
        if (is_array($this->getURLCategoryFilter())) {
            return $this->CategoriesWithState()->filter(['CustomLinkingMode' => 'current'])->first();
        }
    }
}
