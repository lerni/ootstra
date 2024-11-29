<?php

namespace App\Extensions;

use App\Models\Slide;
use SilverStripe\ORM\ArrayList;
use SilverStripe\Core\Extension;
use SilverStripe\View\ArrayData;
use SilverStripe\Blog\Model\Blog;
use SilverStripe\Forms\FieldList;
use SilverStripe\Control\Controller;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldPaginator;
use SilverStripe\Forms\GridField\GridFieldDetailForm;
use SilverStripe\Forms\GridField\GridFieldEditButton;
use SilverStripe\Forms\GridField\GridFieldConfig_Base;
use SilverStripe\Forms\GridField\GridFieldAddNewButton;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use SilverStripe\Forms\GridField\GridFieldAddExistingAutocompleter;

class BlogExtension extends Extension
{
    private static $db = [
        'HeroSize' => 'Enum("small,medium,fullscreen")',
        'PreventHero' => 'Boolean'
    ];

    private static $many_many = [
        'Slides' => Slide::class
    ];

    private static $many_many_extraFields = [
        'Slides' => [
            'SortOrder' => 'Int'
        ]
    ];

    private static $owns = [
        'Slides'
    ];

    public function populateDefaults()
    {
        $siteConfig = SiteConfig::current_site_config();
        if ($heroSize = $siteConfig->DefaultHeroSize) {
            $this->owner->HeroSize = $heroSize;
        }
        $this->owner->PostsPerPage = (int)30;
    }

    public function updateCMSFields(FieldList $fields)
    {
        $fields->removeFieldFromTab('Root.Categorisation', 'Tags');

        $CategoriesField = $fields->fieldByName('Root.Categorisation.Categories');
        $CategoriesFieldConfig = $CategoriesField->getConfig()->addComponents(
            new GridFieldOrderableRows('SortOrder')
        );

        // hack around unsaved relations
        if ($this->owner->isInDB()) {
            $SlideGridFieldConfig = GridFieldConfig_Base::create(20);
            $SlideGridFieldConfig->addComponents(
                new GridFieldEditButton(),
                new GridFieldDeleteAction(false),
                new GridFieldDeleteAction(true),
                new GridFieldDetailForm(),
                new GridFieldAddNewButton('toolbar-header-left'),
                new GridFieldAddExistingAutocompleter('toolbar-header-right'),
                new GridFieldOrderableRows('SortOrder')
            );

            $gridField = new GridField('Slides', 'Slides', $this->owner->Slides(), $SlideGridFieldConfig);
            $fields->addFieldToTab('Root.Main', $gridField, 'Content');

            // HeroSize is respected if slides are present, otherwise default of SiteConfig is used
            if ($this->owner->Slides()->count()) {
                $sizes = singleton(Blog::class)->dbObject('HeroSize')->enumValues();
                $SizeField = DropdownField::create('HeroSize', _t('App\Elements\ElementHero.HEROSIZE', 'Size/Height Header'), $sizes);
                $SizeField->setDescription(_t('App\Elements\ElementHero.SizeDescription', '"fullscreen" requires "full width"!'));
                $fields->addFieldToTab('Root.Main', $SizeField, 'Content', true);
            } else {
                $fields->addFieldToTab('Root.Main', CheckboxField::create('PreventHero', _t('App\Models\ElementPage.PREVENTHERO', 'Do not show default Hero-Slides')), 'Content');
            }

        } else {
            $fields->addFieldToTab('Root.Main', LiteralField::create('firstsave', '<p style="font-weight:bold; color:#555;">' . _t('SilverStripe\CMS\Controllers\CMSMain.SaveFirst', 'none') . '</p>'));
        }

        if ($ChildPagesField = $fields->fieldByName('Root.ChildPages.ChildPages')) {
            $ChildPagesField->getConfig()
                ->getComponentByType(GridFieldPaginator::class)
                ->setItemsPerPage(30); // watch out memory!
            $ChildPagesField->getConfig()->addComponents(
                new GridFieldOrderableRows('Sort')
            );
        }
    }

    public function YearlyArchive()
    {
        $query = $this->owner->getBlogPosts()->dataQuery();
        $query->groupBy("DATE_FORMAT(PublishDate, '%Y')");
        $posts = $this->owner->getBlogPosts()->setDataQuery($query);

        $archive = new ArrayList();

        if ($posts->count() > 0) {
            foreach ($posts as $post) {
                if ($post->PublishDate) {
                    $year = date('Y', strtotime($post->PublishDate));
                    $title = $year;
                    $archive->push(new ArrayData([
                        'Title' => $title,
                        'Link' => Controller::join_links($this->owner->Link('archive'), $year)
                    ]));
                }
            }
        }
        return $archive->Sort('Title DESC');
    }
}
