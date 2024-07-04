<?php

namespace App\Models;

use Page;
use SilverStripe\Control\Director;
use SilverStripe\Control\Controller;
use SilverStripe\SiteConfig\SiteConfig;
use App\Controller\ElementPageController;

class ElementPage extends Page
{
    private static $db = [];

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

        return $fields;
    }
}
