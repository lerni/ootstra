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
            $vcard->addName($perso->Lastname, $perso->Firstname);
            $vcard->addCompany(SiteConfig::current_site_config()->Title);
            $vcard->addJobtitle($perso->Position);
            $vcard->addEmail($perso->EMail);
            $vcard->addPhoneNumber($perso->Telephone, 'PREF;WORK');

            if ($location = SiteConfig::current_site_config()->Locations()->First()) {
                // todo get default country? may from SilverStripe\i18n\Data\getCountries
                // i18n::config()->uninherited('default_locale')
                $c = $location->Country;

                $vcard->addAddress(null, null, $location->Address, $location->Town, null, $location->PostalCode, $location->Country);
                $vcard->addLabel("$location->Address, $location->Town, $location->PostalCode $location->Country");
            }
            $vcard->addURL(Director::protocolAndHost() . Director::get_current_page()->Link() . '#' . $perso->Anchor());
            $vcard->addPhoto(Director::protocolAndHost() . '/' . $perso->Portrait()->ScaleMaxWidth(400)->Link());

            // return vcard as a string
            // return $vcard->getOutput();

            // return vcard as a download
            return $vcard->download();
        }
    }
}
