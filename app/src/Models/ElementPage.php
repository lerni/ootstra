<?php

namespace App\Models;

use Page;
use App\Elements\ElementHero;
use SilverStripe\Assets\Image;
use App\Elements\ElementGallery;
use SilverStripe\Control\Director;
use SilverStripe\Control\Controller;
use SilverStripe\Forms\LiteralField;
use SilverStripe\SiteConfig\SiteConfig;
use App\Controller\ElementPageController;
use DNADesign\Elemental\Extensions\ElementalPageExtension;

class ElementPage extends Page
{
    private static $has_one = [];

    private static $has_many = [];

    private static $owns = [];

    private static $controller_name  = ElementPageController::class;

    private static $table_name = 'ElementPage';

    private static $description = 'Allows modular content composition with elements.';

    public function CanonicalLink()
    {
        if (in_array(Controller::curr()->urlParams['Action'], [
            'job',
            'perso'
        ])) {
            $c = Controller::curr();
            $siteConfig = SiteConfig::current_site_config();
            if ($siteConfig->CanonicalDomain) {
                $base = trim($siteConfig->CanonicalDomain, '/');
            } else {
                $base = Director::absoluteBaseURL();
            }
            // todo: primary should be respected here!!!
            $siteURL = $c->Link();
            $action = $c->urlParams['Action'];
            $id = $c->urlParams['ID'];
            return Controller::join_links(
                $base,
                $siteURL,
                $action,
                $id
            );
        }
    }

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        if (!$this->hasHero()) {
            $message = _t(__CLASS__ . '.HeroNeeded', 'If there is no "Hero" as top element, <a href="/admin/settings/">default HeadeImage</a> is used.');
            $fields->unshift(
                LiteralField::create(
                    'HeroNeeded',
                    sprintf(
                        '<p class="alert alert-warning">%s</p>',
                        $message
                    )
                )
            );
        }

        return $fields;
    }

    // overwriting this form GoogleSitemapSiteTreeExtension,
    // since we do not want to get related pics in automatically
    public function ImagesForSitemap()
    {
        $IDList = [];
        if ($this->hasExtension(ElementalPageExtension::class)) {
            // Images from Heroes
            if ($elementHeros = $this->ElementalArea()->Elements()->filter('ClassName', ElementHero::class)) {
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
            if ($elementGallery = $this->ElementalArea()->Elements()->filter('ClassName', ElementGallery::class)) {
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
