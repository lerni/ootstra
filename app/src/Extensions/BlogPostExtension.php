<?php

namespace App\Extensions;

use App\Elements\ElementHero;
use SilverStripe\Assets\Image;
use App\Elements\ElementGallery;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\HeaderField;
use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\DatetimeField;
use SilverStripe\ORM\FieldType\DBDatetime;
use DNADesign\Elemental\Extensions\ElementalPageExtension;

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
        $SummaryField->setAttribute('data-mce-body-class', $this->owner->ClassName);

        if ($CategoriesField = $fields->dataFieldByName('Categories')) {
            $CategoriesField->setShouldLazyLoad(false);
        }

        if ($PublishDateField = $fields->fieldByName('Root.PostOptions.PublishDate')) {
            $PublishDateField->setDescription(_t('SilverStripe\Blog\Model\BlogPost.PublishDateDescription', 'geplante Veröffentlichung'));
        }
    }

    public function BlogThumbnail()
    {
        if (is_object($this->owner->getDefaultOGImage(1))) {
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

    // overwriting this form GoogleSitemapSiteTreeExtension,
    // since we do not want to get related pics in automatically
    public function ImagesForSitemap()
    {
        $IDList = [];
        if ($this->owner->hasExtension(ElementalPageExtension::class)) {
            // Images from Heroes
            if ($elementHeros = $this->owner->ElementalArea()->Elements()->filter('ClassName', ElementHero::class)) {
                foreach ($elementHeros as $hero) {
                    if ($hero->Slides()->count() && $hero->SitemapImageExpose) {
                        if ($slides = $hero->Slides()->Sort('SortOrder ASC')) {
                            foreach ($slides as $slide) {
                                if ($slide->SlideImage->exists() && !$slide->SlideImage->NoFileIndex()) {
                                    array_push($IDList, $slide->SlideImageID);
                                }
                            }
                        }
                    }
                }
            }
            // Images from ElementGallery
            if ($elementGallery = $this->owner->ElementalArea()->Elements()->filter('ClassName', ElementGallery::class)) {
                foreach ($elementGallery as $gallery) {
                    if ($gallery->Items()->count() && $gallery->SitemapImageExpose) {
                        if ($images = $gallery->Items()) {
                            foreach ($images as $image) {
                                if ($image->exists() && !$image->NoFileIndex()) {
                                    array_push($IDList, $image->ID);
                                }
                            }
                        }
                    }
                }
            }
        }
        $IDList = array_unique($IDList);
        if (count($IDList)) {
            return Image::get()->filter(['ID' => $IDList]);
        }
    }
}
