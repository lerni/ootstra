<?php

namespace App\Models;

use Page;
use PageController;
use SilverStripe\Control\Director;
use SilverStripe\Control\Controller;
use SilverStripe\Forms\LiteralField;
use SilverStripe\SiteConfig\SiteConfig;
use App\Controller\ElementPageController;

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
        if (Controller::curr()->urlParams['Action'] == 'job') {
            $c = Controller::curr();
            $siteConfig = SiteConfig::current_site_config();
            if ($siteConfig->CanonicalDomain) {
                $base = trim($siteConfig->CanonicalDomain, '/');
            } else {
                $base = Director::absoluteBaseURL();
            }
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
            $message = _t('App\Models\ElementPage.HeroNeeded', 'Wenn kein "Hero" als oberstes Element vorhanden ist, wird <a href="/admin/settings/">default HeadeImage</a> verwendet.');
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

    public function hasHero()
    {
        if ($this->hasExtension('DNADesign\Elemental\Extensions\ElementalPageExtension')) {
            if ($this->ElementalArea()->Elements()->Count() && $this->ElementalArea()->Elements()->First()->ClassName == 'App\Elements\ElementHero') {
                return true;
            }
            if ($this->ElementalArea()->Elements()->Count() && $this->ElementalArea()->Elements()->First()->ClassName == 'DNADesign\ElementalVirtual\Model\ElementVirtual') {
                if ($this->ElementalArea()->Elements()->First()->LinkedElement()->ClassName == 'App\Elements\ElementHero') {
                    return true;
                }
            }
        }
    }

    // overwriting this form GoogleSitemapSiteTreeExtension,
    // since we do not want to get related pics in automatically
    public function ImagesForSitemap()
    {
        $list = new ArrayList();

        if ($this->hasExtension(ElementalPageExtension::class)) {
            // Images from Heros
            if ($elementHeros = $this->ElementalArea()->Elements()->filter('ClassName', ElementHero::class)) {
                foreach ($elementHeros as $hero) {
                    if ($hero->Slides()->count()) {
                        if ($slides = $hero->Slides()->Sort('SortOrder ASC')) {
                            foreach ($slides as $slide) {
                                if ($slide->SlideImage->exists()) {
                                    $list->push($slide->SlideImage);
                                }
                            }
                        }
                    }
                }
            }
            // Images from ElementGallery
            if ($elementGallery = $this->ElementalArea()->Elements()->filter('ClassName', ElementGallery::class)) {
                foreach ($elementGallery as $gallery) {
                    if ($gallery->Items()->count()) {
                        if ($images = $gallery->Items()) {
                            foreach ($images as $image) {
                                if ($image->exists()) {
                                    $list->push($image);
                                }
                            }
                        }
                    }
                }
            }
        }
        return $list;
    }
}
