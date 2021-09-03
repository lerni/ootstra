<?php

namespace App\Tasks;

use \Page;
use SilverStripe\Dev\Debug;
use SilverStripe\Dev\BuildTask;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Versioned\Versioned;
use SilverStripe\ORM\Queries\SQLSelect;
use SilverStripe\ORM\FieldType\DBHTMLText;

class MetaTitleOnSiteTree extends BuildTask
{
    protected $description = 'moves MetaTitle to SiteTree';
    private static $segment = 'movemetatitle';

	public function run($request)
    {
        $this->updateMeta();
    }

    function updateMeta()
	{

        // bypassing ORM to get MetaTitles form Page (old)
        // per ORM we get the value form SiteTree - we're migrating to that
        $query = SQLSelect::create()
            ->setFrom('Page')
            ->setWhere(array('MetaTitle IS NOT NULL'));


        $result = $query->execute();

        foreach($result as $row) {
            $page = SiteTree::get_by_id($row['ID']);
            $page->MetaTitle = $row['MetaTitle'];

            // Save, and maybe publish
            $page->write();
            if ($page->isPublished()) {
                $page->publish('Stage', 'Live');
                echo('publishing<br/>');
            }


            $obj= DBHTMLText::create();
            $obj->setValue('<a href="' . $page->Link() . '">' . $page->Title . '</a> has new MetaTitle ' . $page->MetaTitle . '<br/>-------------------<br/>');
            echo ($obj);
        }
    }
}
