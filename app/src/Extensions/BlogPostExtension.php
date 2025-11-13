<?php

namespace App\Extensions;

use SilverStripe\ORM\DB;
use SilverStripe\Core\Extension;
use SilverStripe\Blog\Model\Blog;
use SilverStripe\Forms\FieldList;
use SilverStripe\Blog\Model\BlogPost;

class BlogPostExtension extends Extension
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
        $SummaryField->fieldByName('Summary')->getEditorConfig()->setOption('body_class', 'typography '. $this->getOwner()->ShortClassName($this, true));

        if ($CategoriesField = $fields->dataFieldByName('Categories')) {
            $CategoriesField->setShouldLazyLoad(false);
        }

        if ($PublishDateField = $fields->fieldByName('Root.PostOptions.PublishDate')) {
            $PublishDateField->setDescription(_t('SilverStripe\Blog\Model\BlogPost.PublishDateDescription', 'scheduled publication'));
        }
    }

    public function BlogThumbnail()
    {
        if (is_object($this->getOwner()->getDefaultOGImage(1)) && $this->getOwner()->getDefaultOGImage(1)->exists()) {
            return $this->getOwner()->getDefaultOGImage(1)->CMSThumbnail();
        }
    }

    public function PrevNext($Mode = 'next')
    {
        $list = $this->getOwner()->Parent()->getBlogPosts();

        if ($Mode == 'next') {
            return $list->filter(["Sort:GreaterThan" => $this->getOwner()->Sort])->sort("Sort ASC")->limit(1)->first();
        }
        if ($Mode == 'prev') {
            return $list->filter(["Sort:LessThan" => $this->getOwner()->Sort])->sort("Sort DESC")->limit(1)->first();
        }
    }

    // Blog posts can be created under non-blog pages
    // https://github.com/silverstripe/silverstripe-blog/issues/521
    public function canCreate($member = null, $context = []): ?bool
    {
        $parent = $context['Parent'] ?? null;
        if (!$parent || !$parent instanceof Blog) {
            return false;
        }

        return null;
    }

    // Latest blog posts on top
    public function onBeforeWrite()
    {
        if (!$this->getOwner()->isInDB() && $this->getOwner()->ParentID) {

            $baseTable = $this->getOwner()->baseTable();
            $liveTable = $baseTable . '_Live';

            $lowestSortDraft = BlogPost::get()
                ->filter('ParentID', $this->getOwner()->ParentID)
                ->min('Sort');

            $lowestSortLive = DB::query(sprintf(
                'SELECT MIN(Sort) FROM %s WHERE ParentID = %d',
                $liveTable,
                $this->getOwner()->ParentID
            ))->value();

            $lowestSort = min(
                $lowestSortDraft ?: PHP_INT_MAX,
                $lowestSortLive ?: PHP_INT_MAX
            );
            $this->getOwner()->Sort = $lowestSort ?? 1;

            // Shift all other pages up by 1 in both tables
            // Update draft table
            DB::query(sprintf(
                'UPDATE %s SET Sort = Sort + 1 WHERE ParentID = %d',
                $baseTable,
                $this->getOwner()->ParentID
            ));

            // Update live table
            DB::query(sprintf(
                'UPDATE %s SET Sort = Sort + 1 WHERE ParentID = %d',
                $liveTable,
                $this->getOwner()->ParentID
            ));
        }
    }
}
