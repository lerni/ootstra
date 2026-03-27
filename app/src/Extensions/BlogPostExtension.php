<?php

namespace App\Extensions;

use SilverStripe\ORM\DB;
use SilverStripe\Core\Extension;
use SilverStripe\Blog\Model\Blog;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Blog\Model\BlogPost;
use SilverStripe\Forms\CompositeField;

class BlogPostExtension extends Extension
{
    private static $db = [];

    private static $has_one = [];

    private static $summary_fields = [
        'BlogThumbnail' => 'Thumbnail',
        'Title' => 'Titel',
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

    public function updateCMSActions(FieldList $actions)
    {
        if (!$this->getOwner()->isInDB()) {
            return;
        }

        $prev = $this->PrevNext('prev');
        $next = $this->PrevNext('next');

        if (!$prev && !$next) {
            return;
        }

        $prevButton = LiteralField::create(
            'PrevRecord',
            $prev
                ? '<a class="btn btn-secondary font-icon-left-open action--previous discard-confirmation" href="' . $prev->CMSEditLink() . '" title="' . htmlspecialchars($prev->Title) . '"></a>'
                : '<span class="btn btn-secondary font-icon-left-open disabled"></span>',
        );

        $nextButton = LiteralField::create(
            'NextRecord',
            $next
                ? '<a class="btn btn-secondary font-icon-right-open action--next discard-confirmation" href="' . $next->CMSEditLink() . '" title="' . htmlspecialchars($next->Title) . '"></a>'
                : '<span class="btn btn-secondary font-icon-right-open disabled"></span>',
        );

        $navGroup = CompositeField::create($prevButton, $nextButton)
            ->setName('PreviousAndNextGroup')
            ->addExtraClass('btn-group--circular me-2')
            ->setFieldHolderTemplate(CompositeField::class . '_holder_buttongroup')
            ->addExtraClass('ms-auto');
        $actions->push($navGroup);

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

            $lowestSortDraft = BlogPost::get()->filter(['ParentID' => $this->getOwner()->ParentID])
                ->min('Sort');

            $lowestSortLive = DB::query(sprintf(
                'SELECT MIN(Sort) FROM %s WHERE ParentID = %d',
                $liveTable,
                $this->getOwner()->ParentID,
            ))->value();

            // Handle empty blog (no posts yet) - start at 0
            if ($lowestSortDraft === null && $lowestSortLive === null) {
                $this->getOwner()->Sort = 0;

                return;
            }

            // Get the actual lowest sort value (filter out nulls)
            $lowestSort = 0;
            if ($lowestSortDraft !== null && $lowestSortLive !== null) {
                $lowestSort = min($lowestSortDraft, $lowestSortLive);
            } elseif ($lowestSortDraft !== null) {
                $lowestSort = $lowestSortDraft;
            } elseif ($lowestSortLive !== null) {
                $lowestSort = $lowestSortLive;
            }

            $this->getOwner()->Sort = $lowestSort;

            // Shift all other pages up by 1 in both tables
            DB::query(sprintf(
                'UPDATE %s SET Sort = Sort + 1 WHERE ParentID = %d',
                $baseTable,
                $this->getOwner()->ParentID,
            ));

            DB::query(sprintf(
                'UPDATE %s SET Sort = Sort + 1 WHERE ParentID = %d',
                $liveTable,
                $this->getOwner()->ParentID,
            ));
        }
    }
}
