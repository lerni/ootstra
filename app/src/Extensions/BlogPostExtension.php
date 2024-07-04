<?php

namespace App\Extensions;

use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\DataExtension;

class BlogPostExtension extends DataExtension
{
    private static $db = [];

    private static $has_one = [];

    private static $summary_fields = [
        'BlogThumbnail' => 'Thumbnail',
        'Title' => 'Titel'
    ];

    public function updateCMSFields(FieldList $fields)
    {
        $fields->removeByName('FeaturedImage');
        $fields->removeFieldFromTab('Root.PostOptions', 'Authors');
        $fields->removeFieldFromTab('Root.PostOptions', 'Tags');
        $fields->removeFieldFromTab('Root.PostOptions', 'AuthorNames');

        $SummaryField = $fields->fieldByName('Root.Main.CustomSummary');
        $SummaryField->fieldByName('Summary')->setRows(10);
        $SummaryField->fieldByName('Summary')->getEditorConfig()->setOption('body_class', 'typography '. $this->owner->ShortClassName($this, true));

        if ($CategoriesField = $fields->dataFieldByName('Categories')) {
            $CategoriesField->setShouldLazyLoad(false);
        }

        if ($PublishDateField = $fields->fieldByName('Root.PostOptions.PublishDate')) {
            $PublishDateField->setDescription(_t('SilverStripe\Blog\Model\BlogPost.PublishDateDescription', 'scheduled publication'));
        }
    }

    public function BlogThumbnail()
    {
        if (is_object($this->owner->getDefaultOGImage(1)) && $this->owner->getDefaultOGImage(1)->exists()) {
            return $this->owner->getDefaultOGImage(1)->CMSThumbnail();
        }
    }

    public function PrevNext($Mode = 'next')
    {
        $list = $this->owner->Parent()->getBlogPosts();

        if ($Mode == 'next') {
            return $list->filter(["Sort:GreaterThan" => $this->owner->Sort])->sort("Sort ASC")->limit(1)->first();
        }
        if ($Mode == 'prev') {
            return $list->filter(["Sort:LessThan" => $this->owner->Sort])->sort("Sort DESC")->limit(1)->first();
        }
    }
}
