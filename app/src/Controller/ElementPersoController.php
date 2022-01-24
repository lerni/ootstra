<?php

namespace App\Controller;

use App\Models\Perso;
use SilverStripe\Control\Director;
use JeroenDesloovere\VCard\VCard;
use DNADesign\Elemental\Controllers\ElementController;
use SilverStripe\Control\Controller;
use SilverStripe\i18n\Data\Locales;
use SilverStripe\i18n\i18n;
use SilverStripe\SiteConfig\SiteConfig;

class ElementPersoController extends ElementController
{

    public function Link($action = null)
    {
        $id = $this->element->ID;
        $segment = Controller::join_links('element', $id, $action);
        $page = Director::get_current_page();
        if ($page && !($page instanceof ElementController)) {
            return $page->Link($segment);
        }
        return $segment;
    }

    private static $allowed_actions = [
        'vcard'
    ];

    public function init()
    {
        parent::init();
    }

    public function vcard()
    {
        (int)$ID = $this->getRequest()->param('ID');
        $expose_vcards = $this->config()->get('expose_vcards');
        $perso = Perso::get()->byID($ID);

        if ($perso && $expose_vcards) {

            $vcard = new VCard();
            $charset = 'utf-8';
            $vcard->setCharset($charset);

            $vcard->addName($perso->Lastname, $perso->Firstname);
            $vcard->addCompany(SiteConfig::current_site_config()->Title);
            $vcard->addJobtitle($perso->Position);
            $vcard->addEmail($perso->EMail);
            $vcard->addPhoneNumber($perso->Telephone, 'PREF;WORK');

            if ($location = SiteConfig::current_site_config()->Locations()->First()) {
                $countryCode = $location->Country;
                $AllCountries = i18n::getData()->getCountries();
                $country = $AllCountries[$countryCode];

                $vcard->addAddress(null, null, $location->Address, $location->Town, null, $location->PostalCode, $country);
                $vcard->addLabel("$location->Address, $location->Town, $location->PostalCode $country");
            }
            $vcard->addURL(Director::protocolAndHost() . Director::get_current_page()->Link() . '#' . $perso->Anchor());

            // if a current-folder exists, we assume a symlinked baseFolder like with PHP deployer
            $current = dirname(dirname(Director::baseFolder())) . '/current';
            if (is_dir($current)) {
                $base = dirname(dirname(Director::baseFolder())) . '/shared';
            } else {
                $base = Director::baseFolder();
            }
            $original_filename_relative  = $perso->Portrait()->FocusFillMax(305,400)->Link();
            $original_filename_absolute  = $base . '/public' . $original_filename_relative;

            if ($perso->Portrait() && $perso->Portrait()->exists()) {
                $vcard->addPhoto($original_filename_absolute);
            }

            // return vcard as a string
            // return $vcard->getOutput();

            $this->getResponse()->addHeader("Content-Type", "text/x-vcard; charset=$charset");

            // return vcard as a download
            return $vcard->download();
        } else {
            return $this->owner->httpError(404, _t(__CLASS__ . '.NotFound', 'vCard couldn\'t be found.'));
        }
    }
}
