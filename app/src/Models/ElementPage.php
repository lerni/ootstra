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
            $message = _t('App\Models\ElementPage.HeroNeeded', 'If there is no "Hero" as top element, <a href="/admin/settings/">default HeadeImage </a> is used.');
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
}
