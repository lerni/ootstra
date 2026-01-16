<?php

namespace App\Models;

use Page;
use App\Models\ElementPage;
use SilverStripe\Admin\LeftAndMain;
use SilverStripe\Control\Controller;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Model\List\ArrayList;
use App\Controller\HolderPageController;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\View\Parsers\URLSegmentFilter;
use SilverStripe\Forms\GridField\GridFieldDetailForm;
use SilverStripe\Forms\GridField\GridFieldEditButton;
use SilverStripe\Forms\GridField\GridFieldConfig_Base;
use SilverStripe\Forms\GridField\GridFieldAddNewButton;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use SilverStripe\Forms\GridField\GridFieldFilterHeader;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use SilverStripe\Forms\GridField\GridFieldAddExistingAutocompleter;

class HolderPage extends Page
{
    private static $db = [
        'PreventHero' => 'Boolean'
    ];

    private static $has_one = [];

    private static $owns = [];

    private static $table_name = 'HolderPage';

    private static $allowed_children = [
        ElementPage::class
    ];

    private static $defaults = [
        'HideSubNavi' => true,
        'PreventHero' => true
    ];

    private static $controller_name  = HolderPageController::class;

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->removeByName([
            'PageCategories'
        ]);

        $fields->addFieldToTab('Root.Main', CheckboxField::create('PreventHero', _t('App\Models\ElementPage.PREVENTHERO', 'Do not show default Hero-Slides')), 'Content');

        // hack around unsaved relations
        if ($this->isInDB()) {
            $CatGFConfig = GridFieldConfig_Base::create(20);
            $CatGFConfig->addComponents(
                new GridFieldEditButton(),
                new GridFieldDeleteAction(false),
                new GridFieldDeleteAction(true),
                new GridFieldDetailForm(),
                new GridFieldAddNewButton('toolbar-header-left'),
                new GridFieldAddExistingAutocompleter('toolbar-header-right'),
                new GridFieldOrderableRows('SortOrder')
            );
            $CatGFConfig->removeComponentsByType(GridFieldFilterHeader::class);
            $gridField = new GridField('PageCategories', 'Kategorien', $this->PageCategories(), $CatGFConfig);
            $fields->addFieldToTab('Root.Main', $gridField, 'Content');
        } else {
            $fields->addFieldToTab('Root.Main', LiteralField::create('firstsave', '<p style="font-weight:bold; color:#555;">' . _t('SilverStripe\CMS\Controllers\CMSMain.SaveFirst', 'none') . '</p>'));
        }

        return $fields;
    }

    public function Items()
    {
        //$childrens =  $this->AllChildren();
        $childrens =  ElementPage::get()->filter('ParentID', $this->ID);
        if ($categoryFilter = $this->getURLCategoryFilter()) {
            $childrens = $childrens->filterAny("PageCategories.URLSegment", $categoryFilter);
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
            $filter = new URLSegmentFilter();
            $filter->setAllowMultibyte(true);
            $TitleURLEnc = $filter->filter($cat->Title);
            if ($currentCategories && in_array($TitleURLEnc, $currentCategories)) {
                $cat->CustomLinkingMode = 'current';
            } else {
                $cat->CustomLinkingMode = 'link';
            }
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
                $filter = new URLSegmentFilter();
                $filter->setAllowMultibyte(true);
                $tagsURLEnc[] = $filter->filter($tag);
            }

            $allTags = $this->PageCategories()->Column('Title');
            $AllTagsURLEnc = [];
            foreach ($allTags as $key => $tag) {
                $filter = new URLSegmentFilter();
                $filter->setAllowMultibyte(true);
                $AllTagsURLEnc[$key] = $filter->filter($tag);
            }

            $tagsValid = [];
            foreach ($tagsURLEnc as $item) {
                if (in_array($item, $AllTagsURLEnc)) {
                    $tagsValid[array_search($item, $AllTagsURLEnc)] = $item;
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
