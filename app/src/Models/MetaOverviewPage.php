<?php

namespace App\Models;

use Page;
use PageController;
use SilverStripe\Security\Security;
use SilverStripe\View\Requirements;
use SilverStripe\Security\Permission;
use SilverStripe\CMS\Model\RedirectorPage;

class MetaOverviewPage extends Page
{
    private static $db = [
        'Title' => 'Varchar'
    ];

    private static $table_name = 'MetaOverviewPage';

    private static $icon_class = 'font-icon-p-list';

    private static $defaults = [
        'ShowInMenus' => 0,
        'ShowInSearch' => 0
    ];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->removeByName('Content');
        $fields->removeByName('Root.Main.Metadata');
        $fields->removeByName('Root.Main.Share');

        return $fields;
    }

    public function canView($member = null)
    {
        return Permission::check('CMS_ACCESS_CMSMain', 'any', $member);
    }

    public function canCreate($member = null, $context = [])
    {
        $countAllSuch = $this->ClassName::get()->exclude('ID', $this->ID)->count();
        if ($countAllSuch < 1) {
            return Security::getCurrentUser();
        }
    }

    public function MetaOverview($ParentID = 0) {
        $pages = Page::get()->filter([
            'ParentID' => $ParentID
            // 'ShowInSearch' => 1
        ]);
        $pages = $pages->exclude('ClassName', RedirectorPage::class);
        return $pages;
    }
}

class MetaOverviewPageController extends PageController
{
    public function init()
    {
        parent::init();
        Requirements::insertHeadTags('<meta name="robots" content="noindex">');
    }
}
